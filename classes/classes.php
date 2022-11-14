<?php
class Travel {
    private $travelID;
    private $name;
    private $start;
    private $end;
    private $type;
    private $desc;
    private $data1;
    private $data2;
    private $data3;

    # Constructor
    public function __construct($id, 
                                $name, 
                                $start, 
                                $end, 
                                $type, 
                                $desc, 
                                $data1, 
                                $data2, 
                                $data3){
        $this -> setID($id);
        $this -> setName($name);
        $this -> setStartDate($start);
        $this -> setEndDate($end);
        $this -> setType($type);
        $this -> setDesc($desc);
        $this -> setData1($data1);
        $this -> setData2($data2);
        $this -> setData3($data3);

    }

    #ID
    public function getID(){
        return $this -> travelID;
    }

    public function setID($id){
        $this -> travelID = $id;
    }
    
    #Name
    public function getName(){
        return $this -> name;
    }

    public function setName($name){
        $this -> name = $name;
    }

    #Start
    public function getStartDate(){
        return $this -> start;
    }

    public function setStartDate($start){
        // ToDo itt a bejövő string formázását még meg kell oldani, hogy mindegy legyen milyen formátumban jön a átum a stringben.
        $time = strtotime($start);
        $this -> start = date('Y.m.d.', $time);
    }

    #End
    public function getEndDate(){
        return $this -> end;
    }

    public function setEndDate($end){
        // ToDo itt a bejövő string formázását még meg kell oldani, hogy mindegy legyen milyen formátumban jön a átum a stringben.
        $time = strtotime("$end");
        $this -> end = date('Y.m.d.', $time);
    }

    #Type
    public function getType(){
        return $this -> type;
    }

    public function setType($type){
        $this -> type = $type;
    }

    #Desc
    public function getDesc(){
        return $this -> desc;
    }

    public function setDesc($desc){
        $this -> desc = $desc;
    }

    #Data1
    public function getData1(){
        return $this -> data1;
    }

    public function setData1($data){
        $this -> data1 = $data;
    }

    #Data2
    public function getData2(){
        return $this -> data2;
    }

    public function setData2($data){
        $this -> data2 = $data;
    }

    #Data3
    public function getData3(){
        return $this -> data3;
    }

    public function setData3($data){
        $this -> data3 = $data;
    }
}

class Cost{
    private $costID;
    private $costName;
    private $costValue;
    private $costDevisa;

    public function __construct($id, $name, $value, $devisa){
        $this -> setID($id);
        $this -> setName($name);
        $this -> setValue($value);
        $this -> setDevisa($devisa);
    }

    public function getID(){
        return $this -> costID;
    }

    public function setID($id){
        $this -> costID = $id;
    }

    public function getName(){
        return $this -> costName;
    }

    public function setName($name){
        $this -> costName = $name;
    }

    public function getValue(){
        return $this -> costValue;
    }

    public function setValue($value){
        $this -> costValue = $value;
    }

    public function getDevisa(){
        return $this -> costDevisa;
    }

    public function setDevisa($devisa){
        $this -> costDevisa = strtoupper($devisa);
    }
}

class Package{
    private $packageId;
    private $parcName;
    private $weight;
    private $travelID;
    private $quantity;
    private $ok;
    
    public function __construct($packageId, $name, $weight, $travelID, $quantity, $ok){
        $this -> setID($packageId);
        $this -> setName($name);
        $this -> setWeight($weight);
        $this -> setTID($travelID);
        $this -> setQuantity($quantity);
        $this -> setOK($ok);
    }

    public function getID(){
        return $this -> packageId;
    }

    public function setID($id){
        $this -> packageId = $id;
    }

    public function getName(){
        return $this -> parcName;
    }

    public function setName($name){
        $this -> parcName = $name;
    }

    public function getWeight(){
        return $this -> weight;
    }

    public function setWeight($weight){
        $this -> weight = $weight;
    }

    public function getTID(){
        return $this -> travelID;
    }

    public function setTID($tid){
        $this -> travelID = $tid;
    }

    public function getQuantity(){
        return $this -> quantity;
    }

    public function setQuantity($quantity){
        $this -> quantity = $quantity;
    }

    public function getOK(){
        return $this -> ok;
    }

    public function setOK($ok){
        $this -> ok = $ok;
    }
}

class PackageRef{
    private $packageParc;
    private $packageParcWeight;

    public function __construct($packageParc, $packageParcWeight){
        $this -> setPackageParc($packageParc);
        $this -> setWeight($packageParcWeight);
    }

    public function getPackageParc(){
        return $this -> packageParc;
    }

    public function setPackageParc($parc){
        $this -> packageParc = $parc;
    }

    public function getWeight(){
        return $this -> packageParcWeight;
    }

    public function setWeight($weight){
        $this -> packageParcWeight = $weight;
    }
}

class Poi{
    private $poiID;
    private $name;
    private $desc;
    private $location;

    public function __construct($id, $name, $desc, $location){
        $this -> setID($id);
        $this -> setName($name);
        $this -> setDesc($desc);
        $this -> setLocation($location);
    }

    public function getID(){
        return $this -> poiID;
    }

    public function setID($id){
        $this -> poiID = $id;
    }

    public function getName(){
        return $this -> name;
    }

    public function setName($name){
        $this -> name = $name;
    }

    public function getDesc(){
        return $this -> desc;
    }

    public function setDesc($desc){
        $this -> desc = $desc;
    }

    public function getLocation(){
        return $this -> location;
    }

    public function setLocation($location){
        $this -> location = $location;
    }
}

class Alert{
    private $alertID;
    private $date;
    private $active;
    private $travelID;

    public function __construct($id, $date, $active, $tid){
        $this -> setID($id);
        $this -> setDate($date);
        $this -> setActive($active);
        $this -> setTID($tid);
    }

    public function getID(){
        return $this -> alertID;
    }

    public function setID($id){
        $this -> alertID = $id;
    }

    public function getDate(){
        return $this -> date;
    }

    public function setDate($date){
        $this -> date = $date;
    }

    public function getActive(){
        return $this -> active;
    }
    
    public function setActive($active){
        if(is_bool($active)){
            $this -> active = $active;
        }else{
            $this -> active = FALSE;
        }
    }

    public function getTID(){
        return $this -> travelID;
    }

    public function setTID($tid){
        $this -> travelID = $tid;
    }
}

class Diary{
    private $diaryID;
    private $date;
    private $duration;
    private $activity;
    private $desc;
    private $travelID;
    private $costID;
    private $poiID;
    private $photo;
    
    public function __construct($diaryID, 
                                $date, 
                                $duration, 
                                $activity, 
                                $desc, 
                                $travelID, 
                                $costID,
                                $poiID,
                                $photo){
        

    }
    
    public function getID(){
        return $this -> diaryID;
    }

    public function setID($id){
        $this -> diaryID = $id;
    }

    public function getDate(){
        return $this -> date;
    }

    public function setDate($date){
        $this -> date = $date;
    }

    public function getDuration(){
        return $this -> duration;
    }

    public function setDuration($duration){
        $this -> duration = $duration;
    }

    public function getActivity(){
        return $this -> activity;
    }

    public function setActivity($activity){
        $this -> activity = $activity;
    }

    public function getDesc(){
        return $this -> desc;
    }

    public function setDesc($desc){
        $this -> desc = $desc;
    } 

    public function getTID(){
        return $this -> travelID;
    }

    public function setTID($travelID){
        $this -> travelID = $travelID;
    }
    
    public function getCID(){
        return $this -> costID;
    }

    public function setCID($costID){
        $this -> costID = $costID;
    }
    
    public function getPID(){
       return $this -> poiID;
    }

    public function setPID($poiID){
        $this -> poiID = $poiID;
    }
    
    public function getPhoto(){
        return $this -> photo;
    }
    
    public function setPhoto($photo){
        $this -> photo = $photo;
    }
}
?>