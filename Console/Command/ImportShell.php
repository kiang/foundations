<?php

class ImportShell extends AppShell {

    public $uses = array('Foundation');

    public function main() {
        $this->batchImport();
    }

    public function batchImport() {
        $db = ConnectionManager::getDataSource('default');
        $mysqli = new mysqli($db->config['host'], $db->config['login'], $db->config['password'], $db->config['database']);
        $items = array();
        $dateKeys = array(5, 6, 7, 13, 21, 22, 23, 29, 30);
        $escapesKeys = array(14, 15, 16, 17);
        $fh = fopen(__DIR__ . '/data/all_detail.csv', 'r');
        fgetcsv($fh, 2048);
        $stack = array();
        $sql = array();
        $sn = 1;
        $valueStack = array();
        $directorStack = array();
        while ($line = fgetcsv($fh, 2048)) {
            if (!empty($line[13])) {
                $line[13] = $this->getTwDate($line[13]);
            }
            $key = $line[12] . $line[13];
            if (!isset($stack[$key])) {
                $stack[$key] = array(
                    'id' => String::uuid(),
                    'linked_id' => '',
                    'linked_date' => 0,
                    'line' => array(),
                );
            }
        }
        rewind($fh);
        $sn = 1;
        $titles = fgetcsv($fh, 2048);
        while ($line = fgetcsv($fh, 2048)) {
            $raw = $mysqli->real_escape_string(json_encode(array_combine($titles, $line)));
            foreach ($dateKeys AS $dateKey) {
                $line[$dateKey] = !empty($line[$dateKey]) ? $this->getTwDate($line[$dateKey]) : '';
            }
            $key = $line[12] . $line[13];

            $foundationId = String::uuid();
            $closed = 'NULL';
            if (!empty($line[30])) {
                $closed = "'{$line[30]}'";
            } elseif (!empty($line[29])) {
                $closed = "'{$line[29]}'";
            }
            foreach ($escapesKeys AS $escapesKey) {
                $line[$escapesKey] = $mysqli->real_escape_string($line[$escapesKey]);
            }
            if (empty($line[5])) {
                $line[5] = $line[7];
            }
            $foundationSubmitted = strtotime($line[5]);
            if ($foundationSubmitted > $stack[$key]['linked_date'] || $stack[$key]['linked_date'] === 0) {
                $stack[$key]['linked_date'] = $foundationSubmitted;
                $stack[$key]['linked_id'] = $foundationId;
                $stack[$key]['line'] = $line;
            }
            $valueStack[] = "('{$foundationId}', '{$stack[$key]['id']}', NULL, '{$line[12]}', '{$line[1]}', '{$line[11]}', '{$line[13]}', '{$line[14]}', '{$line[15]}', '{$line[16]}', '{$line[17]}', '{$line[19]}', {$closed}, '{$raw}', '{$line[5]}')";
            $directors = explode('|', $line[33]);
            foreach ($directors AS $director) {
                $director = explode(':', $director);
                if (count($director) === 2) {
                    $directorId = String::uuid();
                    $directorStack[] = "('{$directorId}', '{$foundationId}', '{$director[1]}', '{$director[0]}')";
                }
            }
            ++$sn;

            if ($sn > 50) {
                $sn = 1;
                $mysqli->query('INSERT INTO `foundations` VALUES ' . implode(',', $valueStack) . ';');
                $mysqli->query('INSERT INTO `directors` VALUES ' . implode(',', $directorStack) . ';');
                $valueStack = $directorStack = array();
            }
        }
        if (!empty($valueStack)) {
            $mysqli->query('INSERT INTO `foundations` VALUES ' . implode(',', $valueStack) . ';');
            $mysqli->query('INSERT INTO `directors` VALUES ' . implode(',', $directorStack) . ';');
            $sn = 1;
            $valueStack = $directorStack = array();
        }
        fclose($fh);

        foreach ($stack AS $item) {
            $closed = 'NULL';
            if (!empty($item['line'][30])) {
                $closed = "'{$item['line'][30]}'";
            } elseif (!empty($item['line'][29])) {
                $closed = "'{$item['line'][29]}'";
            }
            $valueStack[] = "('{$item['id']}', NULL, '{$item['linked_id']}', '{$item['line'][12]}', '{$item['line'][1]}', '{$item['line'][11]}', '{$item['line'][13]}', '{$item['line'][14]}', '{$item['line'][15]}', '{$item['line'][16]}', '{$item['line'][17]}', '{$item['line'][19]}', {$closed}, NULL, '{$item['line'][5]}')";
            ++$sn;
            if ($sn > 50) {
                $sn = 1;
                $mysqli->query('INSERT INTO `foundations` VALUES ' . implode(',', $valueStack) . ';');
                $valueStack = array();
            }
        }
        if (!empty($valueStack)) {
            $mysqli->query('INSERT INTO `foundations` VALUES ' . implode(',', $valueStack) . ';');
        }
    }

    public function getTwDate($str) {
        $dateParts = explode('/', $str);
        $dateParts[0] = intval($dateParts[0]) + 1911;
        return implode('-', $dateParts);
    }

}
