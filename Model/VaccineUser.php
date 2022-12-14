<?php
date_default_timezone_set("Africa/Cairo");
class vaccineuser {
    private $name;
    private $doses;
    private $nationalID;
    private $secondDoseDate;
    private $reserveStatus;
    private $reservationNumber;
    private $reservePath;

    function __construct() {
		include_once'../Include/DatabaseClass.php';		
		$this->db = new database();

        @session_start();
        //Retrieving user's main data from the database
        $sql = "SELECT * FROM vaccineuser WHERE UserID = {$_SESSION['id']}";
        $row = $this->db->select($sql);
        $this->name=$row['Name']; //User's name
        $this->doses=$row['DoseNumber']; //Number of doses
        $this->nationalID=$row['NationalID']; //National ID, will be used in the reservation
        $this->secondDoseDate=$row['SecondDoseDate']; //Second dose's allowed date (or later)
        $this->reservePath=$row['ReservationPath'];

        //Retrieving the vaccine reservation's details (if available)
        $sql = "SELECT * FROM vaccineuser INNER JOIN vaccinereservation ON vaccinereservation.User_NationalID = vaccineuser.NationalID 
                WHERE vaccineuser.UserID = {$_SESSION['id']}";
        $count = $this->db->check($sql);
        if ($count > 0) {
            $this->reserveStatus = true; //This will be useful to hide the reservation panel
            $row = $this->db->select($sql);
            //We have a reservation! Get the details
            $this->reservationNumber = $row['ID']; //Reservation number to show
        }
	}

    public function getName(){
        return $this->name;
    }

    public function getDoses(){
        return $this->doses;
    }

    public function getReserveStatus(){
        return $this->reserveStatus;
    }

    public function getReservePath() {
        return $this->reservePath;
    }

    public function getReservation(){
        $sql = "SELECT ID FROM vaccinereservation WHERE User_NationalID= $this->nationalID";
        $reservationNumber = $this->db->select($sql);
        return $this->reservationNumber;
    }

    public function reserveDose($center_contactNum,$vaccine_ID,$reservationDate){
        //We only need to check in case the user is reserving the second dose
        if ($this->doses == 1) {
            if ($reservationDate < $this->secondDoseDate) {
                //In case of a negative difference, we stop the code
                return false;
            }
        }
        //Otherwise, create a reservation
        $sql = "INSERT INTO vaccinereservation (User_NationalID, Center_ContactNum, VaccineID, Date) 
                VALUES ({$this->nationalID}, '$center_contactNum', {$vaccine_ID}, '$reservationDate')";
        $insertion = $this->db->insert($sql);
        if ($insertion) {
            return true;
        }
        
    }

    public function listVaccines(){
        $sql = "SELECT * FROM vaccine";
        $vaccineList= $this->db->display($sql);
        $vaccineNo= $this->db->check($sql);
        for($x=0;$x<$vaccineNo;$x++){
            echo "<tr>";
            echo "<td>". $vaccineList[$x]['Name']."</td>";
            echo "<td>". $vaccineList[$x]['Gap']."</td>";
            echo "<td>". $vaccineList[$x]['Precautions']."</td>";
            echo "</tr>";
        }
    }
}
?>