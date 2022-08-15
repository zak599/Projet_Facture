<?php
require_once 'model.php';
$db= new Database();
//Création des factures
if(isset($_POST['action']) && $_POST['action'] == 'create') {
    extract($_POST);
    $returned = (int)$received-(int)$amount;
    $db->create($customer, $cashier, (int)$amount, (int)$received, (int)$returned, $state);
    echo "perfect";
}


//Récupère les factures
if(isset($_POST['action']) && $_POST['action'] =='fetch') {
    $output = '';
    if($db->countBills() > 0) {
        $bills = $db->read();
       $output .= '
           <table class="table table-striped" >
                <thead>
                   <tr>
                   <th scope="col">#</th>
                   <th scope="col">Client</th>
                   <th scope="col">Caissier</th>
                   <th scope="col">Montant</th>
                   <th scope="col">Perçu</th>
                   <th scope="col">Retourné</th>
                   <th scope="col">Etat</th>
                   <th scope="col">Action</th>
                   </tr>
                </thead>
                <tbody>
       ';
       foreach($bills as $bill) {
        $output .= "
        <tr>
        <th scope=\"row\">$bill->id</th>
        <td>$bill->customer</td>
        <td>$bill->cashier</td>
        <td>$bill->amount</td>
        <td>$bill->received</td>
        <td>$bill->returned</td>
        <td>$bill->state</td>
        <td>
            <a href=\"#\" class=\"text-info me-2 infoBtn\" title=\"Voir détails\" data-id=\"$bill->id\"><i class=\"fas
             fa-info-circle\"></i></a>
            <a href=\"#\" class=\"text-primary me-2 editBtn\" title=\"Modifier\" data-id=\"$bill->id\"><i class=\"fas
             fa-edit\" data-bs-toggle='modal' data-bs-target='#updateModal'></i></a>
            <a href=\"#\" class=\"text-danger me-2 deleteBtn\" title=\"Supprimer\" data-id=\"$bill->id\"><i class=\"fas
             fa-trash-alt\"></i></a>
       </td>
      </tr>
        ";
       }

       $output .= "</tbody></table>";
       echo $output;
    } else {
        echo "<h3>Aucune facture pour le moment</h3>";
    }
} 


//Info pour detail de facture
if (isset($_POST['workingId'])){
    $workingId = (int)$_POST['workingId'];
    echo json_encode($db->getSingleBill($workingId));
}


//Update des factures
if(isset($_POST['action']) && $_POST['action'] == 'update') {
    extract($_POST);
    $returned = (int)$received-(int)$amount;
    $db->update((int)$id, $customer, $cashier, (int)$amount, (int)$received, (int)$returned, $state);
    echo "perfect";
}


//Info pour detail de facture
if (isset($_POST['informationId'])){
    $informationId = (int)$_POST['informationId'];
    echo json_encode($db->getSingleBill($informationId));
}


//Suppresion de facture
if (isset($_POST['deletionId'])){
    $deletionId = (int)$_POST['deletionId'];
    echo $db->delete($deletionId);
}


//Exporter les factures
if(isset($_GET['action']) && $_GET['action'] == 'export') {
    $excelFileName = "factures".date('YmdHis').'.xls';
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=$excelFileName");

    $culumnName = ['id','Client','Caissier','Montant','Perçu', 'retourné', 'Etat'];

    $data = implode("\t", array_values($culumnName)) . "\n";
    if($db->countBills() > 0) {
        $bills = $db->read();
        foreach ($bills as $bill) {
            $excelData = [$bill->id, $bill->customer, $bill->cashier, $bill->amount, $bill->received, $bill->returned, $bill->state];
            $data .= implode(   "\t", $excelData). "\n";
        }
}   else {
    $data = "Aucune facture trouvées..." . "\n";
}

echo $data;
die();

}

?>


