<?php
    namespace app\index\model;
    class Address extends Common{
        public function add($locaData){
            //判断是否设置为默认地址,如果设置为默认地址,将其他默认地址改为0
            if($locaData['default_address']==1){
                $this -> where('default_address',1) -> update(['default_address'=>0]);
            }
            $this -> insert($locaData);
        }
        public function payAddress($add){
            // $this->save($add);
            // dump($add);
            db('address') -> insert($add);
            $new_id = $this -> getLastInsId();
            return $this -> get($new_id);
        }
        public function showAddr(){
            return $this -> order('default_address','desc') -> select();
        }
    }