<?php

class AddressShell extends AppShell {

    public $uses = array('Foundation');

    public function main() {
        $pool = TMP . 'address';
        if (!file_exists($pool)) {
            mkdir($pool, 0777, true);
        }
        $foundations = $this->Foundation->find('list', array(
            'conditions' => array(
                'Foundation.active_id IS NULL',
            ),
            'order' => array(
                'Foundation.fund' => 'DESC',
            ),
            'fields' => array('id', 'address'),
        ));
        foreach ($foundations AS $id => $address) {
            $origin = $address;
            $pos = strpos($address, '號');
            if (false !== $pos) {
                $address = substr($address, 0, $pos + 3);
            }
            $cache = $pool . '/' . md5($address);
            if (!file_exists($cache)) {
                echo "getting {$address}\n";
                $r = file_get_contents('http://posland.g0v.io/?address=' . urlencode($address));
                //$r = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?language=zh-TW&address=' . urlencode($address));
                $r = json_decode($r, true);
                if (!in_array($r['status'], array('OK', 'ZERO_RESULTS'))) {
                    print_r($r);
                    exit();
                } else {
                    file_put_contents($cache, json_encode($r));
                }
            }
        }
    }

}
