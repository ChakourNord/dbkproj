<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location:../Login/login.php ");
}
include "navbarv2.php";
include "../conn.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>

</head>

<body><div id="liveAlertPlaceholder"></div>
<div id="liveAlertPlaceholder"></div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.all.min.js"></script>
  <link rel="stylesheet" href="CSS/all.css">
  <link rel="stylesheet" href="../Login/resources/css/generic.css">
  
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

  <script src="../Login/resources/js/materialize.js"></script>
  <script src="../Login/resources/js/extra.js"></script>
  <script src="../Login/resources/js/extra.js"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
  </script>
  <script src="JS/script.js"> </script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
  </script>

  <div class="box">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#hinzu_m">Hinzu</button>

    <!-- Modal -->
    <div class="modal fade" id="hinzu_m" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Mitarbeiter Hinzufügen</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="add_m.php" method="post">
              <input type="text" name="tabelle" class="none" value="mitarbeiter" placeholder="Modell" style="display: none;">
              <input type="text" name="tabelle" class="none" value="users" placeholder="Modell" style="display: none;">
              <input type="text" name="tabelle" class="none" value="adressen" placeholder="Modell" style="display: none;">
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="inputName">Name</label>
                  <input type="text" class="form-control" name="name" id="inputName" placeholder="Name">
                </div>
                <div class="form-group col-md-6">
                  <label for="inputNachname">Nachname</label>
                  <input type="text" class="form-control" name="nachname" id="inputNachname" placeholder="Nachname">
                </div>
              </div>
              <div class="form-row">
              <div class="form-group  col-md-8">
                <label for="inputPosition">Position</label>
                <input type="text" class="form-control" name="position" id="inputposition" placeholder="position">
              </div>
              <div class="form-group  col-md-3">
                <label for="inputGehalt">Gehalt</label>
                <input type="text" class="form-control" name="gehalt" id="inputgehalt" placeholder="gehalt">
              </div>
              </div>
              <div class="form-row">
              <div class="form-group col-md-6">
                <label for="inputstrasse">strasse</label>
                <input type="text" class="form-control" name="strasse" id="inputstrasse" placeholder="strasse">
              </div>
              <div class="form-group col-md-2">
                <label for="inputhausnummer">hausnummer</label>
                <input type="text" class="form-control" name="hausnummer" id="inputhausnummer" placeholder="hausnummer">
              </div>
              </div>
              <div class="form-row">
              <div class="form-group col-md-8">
                <label for="inputStadt">stadt</label>
                <input type="text" class="form-control" name="stadt" id="inputStadt" placeholder="stadt">
              </div>
              <div class="form-group col-md-2">
                <label for="inputPlz">plz</label>
                <input type="text" class="form-control" name="plz" id="inputplz" placeholder="plz">
              </div>
              </div>
              <div class="form-group">
                <label for="inputLand">land</label>
                <input type="text" class="form-control" name="land" id="inputLand" placeholder="land">
              </div>
              <div class="form-group">
                <label for="inputPasswort">passwort</label>
                <input type="password" class="form-control" name="passwort" id="inputPasswort" placeholder="passwort">
              </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    
    <div class="box">
      <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Nachname</th>
            <th scope="col">Gehalt</th>
            <th scope="col">Position</th>
            <th scope="col"></th>
          </tr>
        </thead>
        <?php 
        $sql = "select * from Mitarbeiter";
        $sql =oci_parse($conn,$sql);
        oci_execute($sql);
        $i = 1;
        while(($row = oci_fetch_array($sql, OCI_BOTH+OCI_RETURN_NULLS)) != false)
        {
          
          echo "
                  <tbody>
                    <tr>
                      <th>
                        ".$i."
                      </th>
                      <th>
                      ".$row[1]."
                      </th>
                      <th>
                      ".$row[2]."
                      </th>
                      <th>
                      ".$row[3]."
                      </th>
                      <th>
                      ".$row[4]."
                      </th>
                      <th class="?>leftth"<?php echo ">
                      "?>
                      <button type="button" class="btn btn-danger del_m_row" data-toggle="modal"   data-table="fahrzeuge" data-id=<?php echo $row[0]?> >delete</button>
                      <button type="button" class="btn btn-info edit_row" data-toggle="modal"   data-table="fahrzeuge" data-id=<?php echo $row[0]?> >info</button>
                      <?php echo "
                      </th>
                    </tr>
                   
                  
                  </tbody>";
                
                $i += 1;
        }
       
      ?>
      </table>
    </div>
  </div>
</body>

</html>
<?php



?>