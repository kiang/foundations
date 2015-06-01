<?php

class ImportShell extends AppShell {

    public $uses = array('Foundation');
    public $all_court = array(
        'TPD' => '臺灣台北地方法院',
        'PCD' => '臺灣新北地方法院',
        'SLD' => '臺灣士林地方法院',
        'TYD' => '臺灣桃園地方法院',
        'SCD' => '臺灣新竹地方法院',
        'MLD' => '臺灣苗栗地方法院',
        'TCD' => '臺灣臺中地方法院',
        'NTD' => '臺灣南投地方法院',
        'CHD' => '臺灣彰化地方法院',
        'ULD' => '臺灣雲林地方法院',
        'CYD' => '臺灣嘉義地方法院',
        'TND' => '臺灣臺南地方法院',
        'KSD' => '臺灣高雄地方法院',
        'PTD' => '臺灣屏東地方法院',
        'TTD' => '臺灣臺東地方法院',
        'HLD' => '臺灣花蓮地方法院',
        'ILD' => '臺灣宜蘭地方法院',
        'KLD' => '臺灣基隆地方法院',
        'PHD' => '臺灣澎湖地方法院',
        'KSY' => '臺灣高雄少年法院',
        'LCD' => '褔建連江地方法院',
        'KMD' => '福建金門地方法院',
    );
    public $dbKeys = array();
    public $dataPath = '/home/kiang/public_html/foundationtw';
    public $mysqli = false;

    public function main() {
        $this->batchImport();
        $this->dumpDbKeys();
    }

    public function dumpDbKeys() {
        $foundations = $this->Foundation->find('all', array(
            'fields' => array('id', 'name', 'founded', 'approved_by', 'active_id'),
            'order' => array('Foundation.founded' => 'ASC'),
        ));
        $check = array();
        $fh = fopen(__DIR__ . '/data/dbKeys.csv', 'w');
        foreach ($foundations AS $foundation) {
            if (empty($foundation['Foundation']['active_id'])) {
                $checkKey = $foundation['Foundation']['name'] . $foundation['Foundation']['founded'];
                if (!isset($check[$checkKey])) {
                    fputcsv($fh, array(
                        $checkKey,
                        $foundation['Foundation']['id'],
                    ));
                    $check[$checkKey] = true;
                }
            }
        }
        fclose($fh);
        $fh = fopen(__DIR__ . '/data/urlKeys.csv', 'w');
        foreach ($foundations AS $foundation) {
            fputs($fh, $foundation['Foundation']['id'] . "\n");
        }
        fclose($fh);

        $approvedKeys = array();
        $fh = fopen(__DIR__ . '/data/approvedKeys.csv', 'w');
        foreach ($foundations AS $foundation) {
            $foundation['Foundation']['approved_by'] = strtr($foundation['Foundation']['approved_by'], array(
                '一' => '1', '二' => '2', '三' => '3', '四' => '4', '五' => '5', '六' => '6', '七' => '7',
                '八' => '8', '九' => '9', '１' => '1', '２' => '2', '３' => '3', '４' => '4', '５' => '5',
                '６' => '6', '７' => '7', '８' => '8', '９' => '9', '０' => '0', 'Ｏ' => '0',
                '（' => '(', '）' => ')', '　' => '', '︵' => '(', '︶' => ')'
            ));
            $foundation['Foundation']['approved_by'] = preg_replace(array(
                '/([1-9])十/',
                '/十([1-9])/',
                '/十/',
                '/廿([1-9])/',
                '/廿/',
                    ), array(
                '${1}',
                '1${1}',
                '10',
                '2${1}',
                '20',
                    ), $foundation['Foundation']['approved_by']);
            if (false !== strpos($foundation['Foundation']['approved_by'], '字') && !isset($approvedKeys[$foundation['Foundation']['approved_by']])) {
                fputcsv($fh, array(
                    $foundation['Foundation']['approved_by'],
                    $foundation['Foundation']['id'],
                ));
                $approvedKeys[$foundation['Foundation']['approved_by']] = true;
            }
        }
        fclose($fh);
    }

    public function batchImport() {
        $db = ConnectionManager::getDataSource('default');
        $this->mysqli = new mysqli($db->config['host'], $db->config['login'], $db->config['password'], $db->config['database']);
        $this->dbQuery('SET NAMES utf8mb4;');
        $foundationKeys = $this->Foundation->find('list', array(
            'fields' => array('id', 'id'),
            'conditions' => array('active_id IS NULL'),
        ));
        $stack = array();
        if (file_exists(__DIR__ . '/data/dbKeys.csv')) {
            $dbKeysFh = fopen(__DIR__ . '/data/dbKeys.csv', 'r');
            while ($line = fgetcsv($dbKeysFh, 1024)) {
                $stack[$line[0]] = array(
                    'id' => $line[1],
                    'is_new' => isset($foundationKeys[$line[1]]) ? false : true,
                    'linked_id' => '',
                    'linked_date' => 0,
                    'line' => array(),
                );
            }
            fclose($dbKeysFh);
        }
        $escapesKeys = array('主事務所', '目的', '捐助方法', '許可機關日期', '法人名稱', '法人代表');
        $dateKeys = array('設立登記日期', '撤銷日期', '註銷日期', '公告日期', '收件日期', '登記日期');
        $valueStack = $directorStack = array();
        $sn = 1;
        foreach ($this->all_court AS $courtKey => $courtName) {
            echo "processing {$this->dataPath}/output/lists/{$courtKey}.csv\n";
            $listFh = fopen("{$this->dataPath}/output/lists/{$courtKey}.csv", 'r');
            fgets($listFh, 2048);
            /*
             * $listLine = Array
              (
              [0] => 法院名稱
              [1] => 登記案號
              [2] => 登記號數
              [3] => 案由
              [4] => 法人名稱
              [5] => 登記日期
              [6] => 類別
              [7] => 設立登記撤銷
              [8] => 設立登記註銷
              [9] => 明細
              [10] => 檔案位置
              [11] => ID
              [12] => 法院代碼
              [13] => page #
              )
             */
            while ($listLine = fgetcsv($listFh, 2048)) {
                /*
                 * $detail[?]
                  登記案號
                  類別
                  案由
                  主任
                  登記號數
                  收件日期
                  登記日期
                  公告日期
                  登記簿
                  任期判定
                  屆期判定
                  法人代表
                  法人名稱
                  設立登記日期
                  主事務所
                  目的
                  捐助方法
                  許可機關日期
                  存立時期
                  財產總額
                  結案原因
                  結案日期
                  歸檔日期
                  發證日期
                  送達代收人姓名
                  送達代收人住址
                  郵遞區號
                  清算人
                  註銷日期
                  撤銷日期
                  撤(註)銷機關文號
                  撤(註)銷原因
                  董監事
                  分事務所
                 */

                $detail = json_decode(file_get_contents("{$this->dataPath}/{$listLine[10]}"), true);
                if (empty($detail['法人名稱']) || $detail['結案原因'] === '未核定') {
                    continue;
                }
                foreach ($dateKeys AS $dateKey) {
                    $detail[$dateKey] = $this->getTwDate($detail[$dateKey]);
                }
                foreach ($escapesKeys AS $escapesKey) {
                    $detail[$escapesKey] = $this->mysqli->real_escape_string($detail[$escapesKey]);
                }
                if ($detail['設立登記日期'] === '1911-00-00' || $detail['設立登記日期'] === '0000-00-00') {
                    $detail['設立登記日期'] = $detail['登記日期'];
                }
                $stackKey = $detail['法人名稱'] . $detail['設立登記日期'];
                if (!isset($stack[$stackKey])) {
                    $stack[$stackKey] = array(
                        'id' => String::uuid(),
                        'is_new' => true,
                        'linked_id' => '',
                        'linked_date' => 0,
                        'line' => array(),
                    );
                }
                $foundationId = String::uuid();
                $closed = 'NULL';
                if (!empty($detail['撤銷日期'])) {
                    $closed = "'{$detail['撤銷日期']}'";
                } elseif (!empty($detail['註銷日期'])) {
                    $closed = "'{$detail['註銷日期']}'";
                }

                if (empty($detail['收件日期'])) {
                    $detail['收件日期'] = $detail['公告日期'];
                }
                $detail['法人代表'] = str_replace(array(' ', '　'), '', $detail['法人代表']);
                $foundationSubmitted = strtotime($detail['收件日期']);
                if ($foundationSubmitted > $stack[$stackKey]['linked_date'] || $stack[$stackKey]['linked_date'] === 0) {
                    $stack[$stackKey]['linked_date'] = $foundationSubmitted;
                    $stack[$stackKey]['linked_id'] = $foundationId;
                    $stack[$stackKey]['line'] = $detail;
                    $stack[$stackKey]['line']['closed'] = $closed;
                    $stack[$stackKey]['line']['court'] = $courtKey;
                    $stack[$stackKey]['line']['url'] = $listLine[9];
                    $stack[$stackKey]['line']['url_id'] = $listLine[11];
                }
                $valueStack[] = implode(',', array(
                    "('{$foundationId}'", //id
                    "'{$stack[$stackKey]['id']}'", //active_id
                    'NULL', //linked_id
                    "'{$detail['法人名稱']}'", //name
                    "'{$detail['類別']}'", //type
                    "'{$detail['法人代表']}'", //representative
                    "'{$detail['設立登記日期']}'", //founded
                    "'{$detail['主事務所']}'", //address
                    "'{$detail['目的']}'", //purpose
                    "'{$detail['捐助方法']}'", //donation
                    "'{$detail['許可機關日期']}'", //approved_by
                    "'{$detail['財產總額']}'", //fund
                    $closed, //closed
                    "'{$courtKey}'", //court
                    "'{$listLine[9]}'", //url
                    "'{$listLine[11]}'", //url_id
                    "'{$detail['收件日期']}')", //submitted
                ));
                if (isset($detail['董監事'])) {
                    foreach ($detail['董監事'] AS $director) {
                        if (count($director) === 2) {
                            $directorId = String::uuid();
                            $director[1] = str_replace(array(' ', '　'), '', $director[1]);
                            $director[1] = $this->mysqli->real_escape_string($director[1]);
                            $directorStack[] = "('{$directorId}', '{$foundationId}', '{$director[1]}', '{$director[0]}')";
                        }
                    }
                }

                ++$sn;

                if ($sn > 50) {
                    $sn = 1;
                    $this->dbQuery('INSERT INTO `foundations` VALUES ' . implode(',', $valueStack) . ';');
                    if (!empty($directorStack)) {
                        $this->dbQuery('INSERT INTO `directors` VALUES ' . implode(',', $directorStack) . ';');
                    }
                    $valueStack = $directorStack = array();
                }
            }
        }
        if (!empty($valueStack)) {
            $this->dbQuery('INSERT INTO `foundations` VALUES ' . implode(',', $valueStack) . ';');
            if (!empty($directorStack)) {
                $this->dbQuery('INSERT INTO `directors` VALUES ' . implode(',', $directorStack) . ';');
            }
            $sn = 1;
            $valueStack = $directorStack = array();
        }
        echo "processing final step\n";

        foreach ($stack AS $item) {
            if (empty($item['linked_id'])) {
                continue;
            }
            if ($item['is_new']) {
                $valueStack[] = implode(',', array(
                    "('{$item['id']}'", //id
                    'NULL', //active_id
                    "'{$item['linked_id']}'", //linked_id
                    "'{$item['line']['法人名稱']}'", //name
                    "'{$item['line']['類別']}'", //type
                    "'{$item['line']['法人代表']}'", //representative
                    "'{$item['line']['設立登記日期']}'", //founded
                    "'{$item['line']['主事務所']}'", //address
                    "'{$item['line']['目的']}'", //purpose
                    "'{$item['line']['捐助方法']}'", //donation
                    "'{$item['line']['許可機關日期']}'", //approved_by
                    "'{$item['line']['財產總額']}'", //fund
                    $item['line']['closed'], //closed
                    "'{$item['line']['court']}'", //court
                    "'{$item['line']['url']}'", //url
                    "'{$item['line']['url_id']}'", //url_id
                    "'{$item['line']['收件日期']}')", //submitted
                ));
                ++$sn;
                if ($sn > 50) {
                    $sn = 1;
                    $this->dbQuery('INSERT INTO `foundations` VALUES ' . implode(',', $valueStack) . ';');
                    $valueStack = array();
                }
            } else {
                $this->dbQuery("UPDATE foundations SET linked_id = '{$item['linked_id']}' WHERE id = '{$item['id']}';");
            }
        }
        if (!empty($valueStack)) {
            $this->dbQuery('INSERT INTO `foundations` VALUES ' . implode(',', $valueStack) . ';');
        }
    }

    public function getTwDate($str) {
        $str = trim($str);
        if (empty($str)) {
            return '0000-00-00';
        }
        $dateParts = explode('/', $str);
        $dateParts[0] = intval($dateParts[0]) + 1911;
        if ($dateParts[0] > date('Y')) {
            $dateParts[0] = date('Y');
        }
        return implode('-', $dateParts);
    }

    public function dbQuery($sql) {
        if (!$this->mysqli->query($sql)) {
            printf("Error: %s\n", $this->mysqli->error);
            echo $sql;
            exit();
        }
    }

}
