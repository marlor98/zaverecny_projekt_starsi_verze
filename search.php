<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$hledat = $hledat_podle = "";
$hledat_err = $hledat_podle_err = "";
if(!empty($_POST))
{
    $input_hledat = trim($_POST['hledat']);
    $hledat_podle = $_POST['hledat_podle'];

    if(empty($input_hledat))
    {
        $hledat_err = "Zadejte, co chcete hledat.";
    }
    else
    {
        $hledat = $input_hledat;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hledání záznamu</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
	<style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
        .wrapper1{
            width: 650px;
            margin: 0 auto;
        }
        .page-header h2{
            margin-top: 0;
        }
        table tr td:last-child a{
            margin-right: 15px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <ul class="nav navbar-nav">
                <li ><a href="popis.php">Úvod</a>
                <li ><a href="index.php">Zákazníci</a></li>
                <li class="active"><a href="search.php">Vyhledávání</a></li>
            </ul>
        </div>
    </nav>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Hledání záznamu</h2>
                    </div>
                    <p>Vyplňte prosím požadovaná pole a odešlete.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group">
                            <label>Hledat podle</label>
                            <select name="hledat_podle" class="form-control">
                              <option value="jmeno">Jméno</option>
                              <option value="prijmeni">Příjmení</option>
                              <option value="ulice">Ulice</option>
                              <option value="cp">Číslo popisné</option>
                              <option value="mesto">Město</option>
                              <option value="psc">PSČ</option>
                            </select>
                            <span class="help-block"><?php echo $hledat_podle_err;?></span>
                            <label>Co hledat</label>
                            <input type="text" name="hledat" class="form-control" value="<?php echo $hledat; ?>">
                            <span class="help-block"><?php echo $hledat_err;?></span>
                        </div>


                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-default">Zrušit</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
	<?php

 // Validate input

  if(!empty($_POST))
  {
    $input_hledat = trim($_POST['hledat']);
    $hledat_podle = $_POST['hledat_podle'];

    if(empty($input_hledat)){
        $hledat_err = "Zadejte co chcete hledat.";
    } else{
        $hledat = $input_hledat;
    }
  }
    // Check input errors before inserting in database
    if(!empty($_POST) and empty($hledat_err)){
        $sql  = "SELECT *  FROM zakaznici WHERE ".$hledat_podle." LIKE '%".$hledat."%'";
?>
	<div class="wrapper1">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="page-header clearfix">
                        <h3>Nalezené záznamy</h3>
                    </div>
<?php
        if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
			                            echo "<table class='table table-bordered table-striped'>";
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>#</th>";
                                        echo "<th>"."Jméno"."</th>";
                                        echo "<th>"."Přijmení"."</th>";
                                        echo "<th>"."Ulice"."</th>";
                                        echo "<th>"."Číslo popisné"."</th>";
                                        echo "<th>"."Město"."</th>";
              							            echo "<th>"."PSČ"."</th>";
              							            echo "<th>Action</th>";
							         echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                      echo "<tr>";
                                          echo "<td>" . $row['id'] . "</td>";
  									    echo "<td>" . $row['jmeno'] . "</td>";
                                          echo "<td>" . $row['prijmeni'] . "</td>";
                                          echo "<td>" . $row['ulice'] . "</td>";
                                          echo "<td>" . $row['cp'] . "</td>";
                                          echo "<td>" . $row['mesto'] . "</td>";
                                          echo "<td>" . $row['psc'] . "</td>";
  									    echo "<td>";
                                            echo "<a href='read.php?id=". $row['id'] ."' title='View Record' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
                                            echo "<a href='update.php?id=". $row['id'] ."' title='Update Record' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                                            echo "<a href='delete.php?id=". $row['id'] ."' title='Delete Record' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";
                            echo "</table>";
                            // Free result set
                            mysqli_free_result($result);
                        } else{
                            echo "<p class='lead'><em>Nebyly nalezeny žádné záznamy.</em></p>";
                        }
                    } else{
                        echo "ERROR: Nelze provést dotaz $sql. " . mysqli_error($link);
                    }

                    // Close connection
                    mysqli_close($link);
    }

?>
					</div>
            </div>
        </div>
    </div>

</body>


</html>
