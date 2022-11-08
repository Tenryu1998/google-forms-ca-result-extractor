<?php
require __DIR__ . '/vendor/autoload.php';
class Extract
{
    public $csv;
    public $csv_array;
    public $results;
    public $class;
    function __construct ($class,$csv) {
        $this->csv = $csv;
        $this->class = $class;
    }


    public function loadCSV()
    {

        $DATA = ['total' => 0,'arms' => []];
        //print_r($this->class);
        //read and seperate according to arms
        foreach ($this->csv as $csv) {
            $open = fopen($this->class."/".$csv,"r");
            if ($open) {
                $i = 0;
                while (($row = fgetcsv($open,10000000,",")) !== false) {
                    if ($i > 0) {
                        $data['name'] = $row[2];
                        $data['score'] = str_replace(" / 10","",$row[1]) ;
                        $data['arm'] = strtoupper($row[5]);
                        $data['time'] = $row[0];
                        
                        $DATA['arms'][$data['arm']]['total'] += 1;
                        $DATA['arms'][$data['arm']]['students'][] = $data;
                        $DATA['total'] += 1;

                    }
                    $i++;
                }

            }

            fclose($open);
        }

        //arrange students alphabetically
        if ($DATA['total'] > 0) {
            foreach ($DATA['arms'] as $k => $v) {
                $arm = $DATA['arms'][$k];
                if (!empty($arm['students'])) {
                    $col = array_column( $arm['students'], "name" );
                    array_multisort( $col, SORT_ASC, $arm['students'] );

                    $DATA['arms'][$k]['students'] = $arm['students'];
                }
            }
        }
        //arrange arms alphabetically
        ksort($DATA['arms']);

        return $DATA;

    }



    function combine($arr) {
        $data['total'] = 0;
        $data['arms'] = [];
        foreach ($arr as $ar) {
            $arms = $ar['arms'];
            if (!empty($arms)) {

                foreach ($arms as $armKey => $armVal) {
                    if ($arms[$armKey]['total'] > 0) {
                        foreach ($arms[$armKey]['students'] as $std) {
                            $data['arms'][$armKey]['total'] += 1;
                            $data['arms'][$armKey]['students'][] = $std;
                            $data['total'] += 1;
                        }
                    }
                }
            }
        }

        return $data;
    }

    public function save($fname,$data)
    {
        if ($data['total'] > 0) {
            foreach ($data['arms'] as $armK => $armV) {
                $res = $data['arms'][$armK]['students'];
                array_unshift($res,['name','score','arm','time']);
                
                $xlsx = Shuchkin\SimpleXLSXGen::fromArray($res);
                $xlsx->saveAs($this->class.'/'.$fname.'-'.$armK.'.xlsx');
               
            }
        }
        return $data;
    }


    


}


?>