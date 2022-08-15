<?php
  // Initialiser la session
  session_start();
  // Vérifiez si l'utilisateur est connecté, sinon redirigez-le vers la page de connexion
  if(!isset($_SESSION["username"])){
    header("Location: login.php");
    exit(); 
  }
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
  

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jqc-1.12.4/dt-1.12.1/datatables.min.css"/>
 
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" 
    integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
 


    <title>Document</title>
</head>

<body>
<div class="sucess">
    <h1>Bienvenue <?php echo $_SESSION['username']; ?>!</h1>
    <p>Voici vos factures</p>
    <a href="logout.php">Déconnexion</a>
    <header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">PROJET</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Link</a>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
</header>
<section class="container py-5">

<!-- Modal -->
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createModalLabel">Nouvelle facture</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">  
      <form action="" method="post" id="formOrder">
        <div class="form-floating mb-3">
          <input type="text" class="form-control" id="customer" name="customer">
          <label for="customer">Nom du client</label>
        </div>  
        <div class="form-floating mb-3">
          <input type="text" class="form-control" id="cashier" name="cashier">
          <label for="cashier">Nom du caissier</label>
        </div>  
        <div class="row g-2">
          <div class="col-md">
            <div class="form-floating mb-3">
          <input type="text" class="form-control" id="amount" name="amount">
          <label for="amount">Montant</label>
            </div>
          </div>  

        <div class="col-md">
            <div class="form-floating mb-3">
          <input type="text" class="form-control" id="received" name="received">
          <label for="received">Montant perçu</label>
            </div>
        </div>    
        <div class="col-md">
            <div class="form-floating">
              <select class="form-select" id="state" aria-label="state" name="state">
                <option value="Facturée">Facturée</option>
                <option value="Payée">Payée</option>
                <option value="Annulée">Annulée</option>
              </select>
              <label for="state">Etat</label> 
            </div>
</div>
</div>   
    </form>  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
        <button type="button" class="btn btn-primary" name="create" id="create">Ajouter <i class="fas fa-plus"></i></button>
      </div>
    </div>
  </div>
</div>
    <div class="row">
        <div class="col-lg-8 col-sm mb-5 mx-auto">
            <h1 class="fs-4 text-center lead text-primary">Principes algorithmiques et programmation</h1>
    </div>
    <div class="dropdown-divider border-warning"></div>
    <div class="row Exporter </a>">
        <div class="col-md-6">
        <h5 class="fw-bold mb-8">LISTE DES FACTURES</h5>
    </div>
    <div class="col-md-6">
      <div class="d-flex justify-content-end">
        <button class="btn btn-primary btn-sm me-3" data-bs-toggle="modal"
         data-bs-target="#createModal"><i class="fas fa-folder-plus"></i> Nouveau </button>
        <a href="/process.php?action=export" class="btn btn-succes btn-sm" id="export"><i class="fas fa-table"></i> Exporter </a>
      </div>
    </div>
  </div>
    <div class="dropdown-divider border-warning"></div>
    <div class="row">
      <div class="table-responsive" id="orderTable">
        <h3 class="text-succes text-center">Chargement des factures...</h3>
</div>
</div>
</section>

<!-- updateModal -->
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="updateModalLabel">Modifier facture</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">  
      <form action="" method="post" id="formUpdateOrder">
        <input type="hidden" name="id" id="bill_id">
        <div class="form-floating mb-3">
          <input type="text" class="form-control" id="customerUpdate" name="customer">
          <label for="customerUpdate">Nom du client</label>
        </div>  
        <div class="form-floating mb-3">
          <input type="text" class="form-control" id="cashierUpdate" name="cashier">
          <label for="cashierUpdate">Nom du caissier</label>
        </div>  
        <div class="row g-2">
          <div class="col-md">
            <div class="form-floating mb-3">
          <input type="text" class="form-control" id="amountUpdate" name="amount">
          <label for="amountUpdate">Montant</label>
            </div>
          </div>  

        <div class="col-md">
            <div class="form-floating mb-3">
          <input type="text" class="form-control" id="receivedUpdate" name="received">
          <label for="receivedUpdate">Montant perçu</label>
            </div>
        </div>    
        <div class="col-md">
            <div class="form-floating">
              <select class="form-select" id="stateUpdate" aria-label="stateUpdate" name="state">
                <option value="Facturée">Facturée</option>
                <option value="Payée">Payée</option>
                <option value="Annulée">Annulée</option>
              </select>
              <label for="stateUpdate">Etat</label> 
            </div>
</div>
</div>   
    </form>  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
        <button type="button" class="btn btn-primary" name="update" id="update">Mettre à jour<i class="fas fa-sync"></i></button>
      </div>
    </div>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" referrerpolicy="no-referrer"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jqc-1.12.4/dt-1.12.1/datatables.min.js"></script>
<script crossorigin="anonymous" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" 
src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="process.js"></script>


</body>
</html>


