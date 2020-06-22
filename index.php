<!DOCTYPE html>

<head>
	<title>CarTest</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="css/styleComm.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css">
	<link rel="stylesheet" href="css/style2.css">
	<script src="maps.js"></script>
	<script type="text/javascript" src="js/jquery.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
	<script type="text/javascript" src="js/javaScript1.js"></script>

</head>

<body>
	
	
<?php 
	include "database/dbconn.php";
	include "database/createdb.php";
	include "database/insert_data.php";
	include "database/select_data.php";
	include "database/setComments.php";
	include "getComments.php";
	//include "emailconfirm.php";
	

	session_start();
	
	$servername = "localhost";
	$username = "";
	$username_database = "root";
	$password = "";
	$db_name = "automobili";
	$table1_name = "vozila";
	$table2_name = "registracija";
	$result;
	$username_form;
	$password_form;
	$email_form;
	$message_one = "";
	date_default_timezone_set('Europe/Belgrade');
	$_SESSION['username'] = "Gost";

	
	$conn = dbConnection($servername, $username_database, $password, $db_name);
	

    


	if(!$conn->connect_error) {

		//Pocetak forme za registraciju i logovanje

		  if (isset($_POST['form_button'])){
        $username_form = $_POST['username'];
		$email_form = $_POST['email'];
        $password_form = $_POST['password'];

        $enc_password = md5($password_form);
 
      	if($username_form && $email_form && $password_form){

        $confirmcode = rand();
      

        insertData($conn, $table2_name, "$username_form", "$email_form", "$password_form", "0", "$confirmcode");
      		
      	 $result = mysqli_query($conn, $table2_name);

        $message = "
        Potvrdite vas email
        Kopirajte link u vasem pretrazivacu za potvrdu email-a
        localhost/project/emailconfirm.php?username=$username_form&code=$confirmcode
        ";
        mail($email_form, "Potvrda email-a", $message);
        $ok = "Registracija je uspesna! Potvrdite vas email.";
        echo "<script type='text/javascript'>alert(\"$ok\");</script>";
      	}
    	}	
	     else if(isset($_POST['login_button'])){
	    	  $username = $_POST['username'];
			  $password = $_POST['password'];
			  $confirmed = "1";

			  $result=mysqli_query( $conn, "select * from registracija where username = '$username' and password = '$password'")
			  						or die("Niste se uspesno ulogovali." .mysql_error());
			  $row = mysqli_fetch_array($result);

				  if($row['username'] == $username && $row['password'] == $password && $row['confirmed'] == $confirmed ){
				  	 $_SESSION['username'] = $row['username'];
					 $_SESSION['message'] = "Uspesno ste se ulogovali.";
					 $message_one = "Odjavite se";
					 $ok = "Uspesno ste se ulogovali.";
					  echo "<script type='text/javascript'>alert(\"$ok\");</script>";
				  }
				  else{
				  	$_SESSION['message'] = "Niste se uspesno ulogovali.";
				  	$error = "Niste se uspesno ulogovali.";
				  echo "<script type='text/javascript'>alert(\"$error\");</script>";
				  };
	    }


	    	//Log out
	    	if(isset($_POST['logout'])){
				session_destroy();
				// unset($_SESSION['username']);
				$_SESSION['username'] = "";
				$_SESSION['message'] = "Odjavili ste se uspesno";
				$message_one = "";
				// header("location : index.php" );
				$message_two = $_SESSION['message'] ;
				  echo "<script type='text/javascript'>alert(\"$message_two\");</script>";
	    	}

	    	//Kraj log out

	    //kraj forme za reg i log

	    //Pocetak komentara
	    	if(isset($_POST['submit_comment'])){
				$uid = $_POST['id_comment'];
				$date = $_POST['date_comment']; 
				$message = $_POST['message'];

				setComments($conn, $table2_name,"$uid", "$message", "$date");
      		
      			 $result1 = mysqli_query($conn, $table2_name);
			}

	    //Kraj komentara

	}

	 else {
		echo("Failed to connect");
	}	
	
?>





<!--pocetak headera-->
<header>
	<div id="menu">
		<a href="#"><img class="zamenaSlike" src="img/logo1.png"></a>
		<div id="logo">
			<a href="#"><img src="img/logo.png"></a>
		</div>
		<div id="logo1">
			<a href="#"><img src="img/logo1.png"></a>
		</div>
		<div id="menuItem">
			<nav>
				<img src="https://image.flaticon.com/icons/png/128/148/148795.png" id="headerIcon" />
				<ul class="nav nav-tabs">
					<li class="active"><a data-toggle="tab" href="#strana1">Naslovna</a></li>
					<li><a data-toggle="tab" href="#strana2">O nama</a></li>
					<li><a data-toggle="tab" href="#strana3">Kontakt</a></li>
					<li><a href="#" data-toggle="modal" data-target="#myModal6">Registracija</a></li>
					<li class="userAccount"><a class="profile">
						<?php if($_SESSION['username']!="Gost"){
							echo $_SESSION['username'];
						}

					 ?></a></li>
						
				    <li>
				    	<form method="POST" action="index.php">
				    		<input name="logout" type="submit" id="logOut_button" value="<?php echo $message_one ?>">
				    	</form>
				    	
				</ul>

			</nav>
		</div>
	</div>
</header>
<!--kraj header-->

<!--pocetak slider-->
<div class="slider">
	<div id="myCarousel" class="carousel slide" data-ride="carousel">

		<!-- Wrapper for slides -->
		<div class="carousel-inner" role="listbox">
			<div class="item active">
				<img src="img/bmw.jpg" alt="Image">
			</div>

			<div class="item">
				<img src="img/truck.jpg" alt="Image">
			</div>

			<div class="item">
				<img src="img/1.png" alt="Image">
			</div>

			<div class="item">
				<img src="img/audi.jpg" alt="Image">
			</div>
		</div>

		<!-- Left and right controls -->
		<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
			<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
			<span class="sr-only">Previous</span>
		</a>
		<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
			<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
			<span class="sr-only">Next</span>
		</a>
	</div>
</div>
<br/>

<!--kraj slidera-->
<!--dialog za registraciju-->


						<div id="myModal6" class="modal fade" role="dialog" action="index.php?vest">
							<div class="dialog-registracija modal-dialog">

								<!-- Modal content-->
								<div class="registracija modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h4 class="modal-title">Registruj se</h4>
									</div>

									<div class="modal-footer">
											<div class="reg_forma">
										      <form class="form-signin" method="POST" action= "index.php">
										        <h2 class="form-signin-heading">Unesite podatke</h2>
										        <div class="input-group">
											  <span class="input-group-addon" id="basic-addon1">@</span>
											  <input type="text" name="username" class="form-control" placeholder="Username" required>
											</div>
										       
										        <label for="inputPassword" class="sr-only">Password</label>
										        <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
										        <label for="inputEmail" class="sr-only">Email address</label>
										        <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address" >
										        <button name="form_button" class="btn btn-lg btn-primary btn-block" type="submit">Register</button>
										        <button name="login_button" class="btn btn-lg btn-primary btn-block">Login</button>
										      </form>
										</div>
									</div>
								</div>

							</div>
						</div>

						<!-- kraj dialoga-->


<!--pocetak sadrzaj-a-->
<div class="tab-content">
	<div id="strana1" class="tab-pane fade in active">
		<div id="pozadina">
			<div class="row" id="sirina">
				<div class="col-lg-12">
					<div class="col-lg-8">
						<div id="pretraga">
							<h2>Pretraga automobila</h2>
							<div id="unos">
								<form method="POST" action="index.php">

									<input type="text" name="textSearch">
									<input type="submit" name="searchButton" class="search" value="Pretraži">
								</form>
							</div>
						</div>


 		<?php
 		if(isset($_POST['searchButton'])){
			 $firstColumn = $conn->real_escape_string($_POST['textSearch']);
			 if($firstColumn === ""){
			 	$error = "Unesite naziv auta.";
				echo "<script type='text/javascript'>alert(\"$error\");</script>";
			 }
			 else{
				$sql = $conn->query("SELECT * FROM vozila WHERE Naziv_auta LIKE '%$firstColumn%' ");
				
				
				if($sql->num_rows > 0){
					while ($data = $sql->fetch_array()){
						
						echo "<div class='slikaTekst col-lg-12'>";
							echo "<div class='slika col-lg-5'>";
								$s=$data['Slika'];
								echo '<img src="'.$s.'" >';
							echo "</div>";	
							echo "<div class='tekst col-lg-7'>";	
							    echo "<div class='sadrzajAuta col-lg-12'>";
							    	echo "<h3 class='naslovAudi'>";
										echo $data['Naziv_auta'].'<br>';
									echo "</h3>";
									echo "Cena: ".$data['Cena'].'<br>';
									echo "Tip motora: ".$data['Tip_motora'].'<br>';
									echo "Boja: ".$data['Boja_auta'].'<br>';
									echo "Tip auta: ".$data['Tip_auta'].'<br>';
									echo "Godina proizvodnje: ".$data['Godina_proizvodnje'].'<br>';
								echo "</div>";
							echo "</div>";	
						echo "</div>";
							
	
							}
				}
				else
					echo "<p class='searchError'>Trazeni automobil nije pronadjen</p>";
						// echo "Trazeni automobil nije pronadjen";
					// echo "</p>";
			}
		}
		?>

						<!--dialog za automobile-->


						<div id="myModal1" class="modal fade" role="dialog">
							<div class="modal-dialog">

								<!-- Modal content-->
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h4 class="modal-title">Ocenite automobil</h4>
									</div>

									<div class="modal-footer">
										<form class="example-form" action="#">
											<h2 class="dialogNaslov">Audi 2016 Benzin 150KS 2.0 Germany</h2>
											<div class="dialogImg">
												<img src="img/audi1.jpg">
											</div>
											<div class="dialogText">

												<table class="tabela">
													<tr>
														<th>Karakteristike</th>
														<th>Min</th>
														<th>Max</th>
													</tr>
													<tr>
														<td>Dozvoljena tezina</td>
														<td>/</td>
														<td>1650kg</td>
													</tr>
													<tr>
														<td>Rastojanje pedala</td>
														<td>920mm</td>
														<td>1220mm</td>
													</tr>
													<tr>
														<td>Udaljenost naslona</td>
														<td>512mm</td>
														<td>816mm</td>
													</tr>
													<tr>
														<td>Zapremina rezervoara</td>
														<td>/</td>
														<td>75l</td>
													</tr>
													<tr>
														<td>Zapremina prtljaznika</td>
														<td>410l</td>
														<td>925l</td>
													</tr>
													<tr>
														<td>Cena</td>
														<td>19.000$</td>
														<td>27.500$</td>
													</tr>
												</table>
												<input type="number" name="number" class="number" required min="1" max="10" step="1" placeholder="Oceni automobil">
												<input class="Ocena" type="submit" value="Posalji">
											</div>
										</form>
									</div>
								</div>

							</div>
						</div>


						<div id="myModal2" class="modal fade" role="dialog">
							<div class="modal-dialog">

								<!-- Modal content-->
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h4 class="modal-title">Ocenite automobil</h4>
									</div>
									<div class="modal-footer">

										<form class="example-form" action="#">
											<h2 class="dialogNaslov">BMW 320D 2016 Benzin 210KS 2.6</h2>
											<div class="dialogImg">
												<img src="img/bmw1.jpg">
											</div>
											<div class="dialogText">

												<table class="tabela">
													<tr>
														<th>Karakteristike</th>
														<th>Min</th>
														<th>Max</th>
													</tr>
													<tr>
														<td>Dozvoljena tezina</td>
														<td>/</td>
														<td>1650kg</td>
													</tr>
													<tr>
														<td>Rastojanje pedala</td>
														<td>920mm</td>
														<td>1220mm</td>
													</tr>
													<tr>
														<td>Udaljenost naslona</td>
														<td>512mm</td>
														<td>816mm</td>
													</tr>
													<tr>
														<td>Zapremina rezervoara</td>
														<td>/</td>
														<td>75l</td>
													</tr>
													<tr>
														<td>Zapremina prtljaznika</td>
														<td>410l</td>
														<td>925l</td>
													</tr>
													<tr>
														<td>Cena</td>
														<td>25.000$</td>
														<td>27.500$</td>
													</tr>
												</table>
												<input type="number" name="number" class="number" required min="1" max="10" step="1" placeholder="Oceni automobil">
												<input class="Ocena" type="submit" value="Posalji">
											</div>
										</form>
									</div>
								</div>

							</div>
						</div>


						<div id="myModal3" class="modal fade" role="dialog">
							<div class="modal-dialog">

								<!-- Modal content-->
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h4 class="modal-title">Ocenite automobil</h4>
									</div>

									<div class="modal-footer">
										<form class="example-form" action="#">
											<h2 class="dialogNaslov">Rover 2015 Benzin 330KS 3.2 UK</h2>
											<div class="dialogImg">
												<img src="img/rover3.jpg">
											</div>
											<div class="dialogText">

												<table class="tabela">
													<tr>
														<th>Karakteristike</th>
														<th>Min</th>
														<th>Max</th>
													</tr>
													<tr>
														<td>Dozvoljena tezina</td>
														<td>/</td>
														<td>1650kg</td>
													</tr>
													<tr>
														<td>Rastojanje pedala</td>
														<td>920mm</td>
														<td>1220mm</td>
													</tr>
													<tr>
														<td>Udaljenost naslona</td>
														<td>512mm</td>
														<td>816mm</td>
													</tr>
													<tr>
														<td>Zapremina rezervoara</td>
														<td>/</td>
														<td>75l</td>
													</tr>
													<tr>
														<td>Zapremina prtljaznika</td>
														<td>410l</td>
														<td>925l</td>
													</tr>
													<tr>
														<td>Cena</td>
														<td>19.000$</td>
														<td>22.500$</td>
													</tr>
												</table>
												<input type="number" name="number" class="number" required min="1" max="10" step="1" placeholder="Oceni automobil">
												<input class="Ocena" type="submit" value="Posalji">
											</div>
										</form>
									</div>
								</div>

							</div>
						</div>



						<div id="myModal4" class="modal fade" role="dialog">
							<div class="modal-dialog">

								<!-- Modal content-->
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h4 class="modal-title">Ocenite automobil</h4>
									</div>

									<div class="modal-footer">
										<form class="example-form" action="#">
											<h2 class="dialogNaslov">Audi A8 2017 Benzin 270KS 3.4</h2>
											<div class="dialogImg">
												<img src="img/audi3.png">
											</div>
											<div class="dialogText">

												<table class="tabela">
													<tr>
														<th>Karakteristike</th>
														<th>Min</th>
														<th>Max</th>
													</tr>
													<tr>
														<td>Dozvoljena tezina</td>
														<td>/</td>
														<td>1650kg</td>
													</tr>
													<tr>
														<td>Rastojanje pedala</td>
														<td>920mm</td>
														<td>1220mm</td>
													</tr>
													<tr>
														<td>Udaljenost naslona</td>
														<td>512mm</td>
														<td>816mm</td>
													</tr>
													<tr>
														<td>Zapremina rezervoara</td>
														<td>/</td>
														<td>75l</td>
													</tr>
													<tr>
														<td>Zapremina prtljaznika</td>
														<td>410l</td>
														<td>925l</td>
													</tr>
													<tr>
														<td>Cena</td>
														<td>19.000$</td>
														<td>27.500$</td>
													</tr>
												</table>
												<input type="number" name="number" class="number" required min="1" max="10" step="1" placeholder="Oceni automobil">
												<input class="Ocena" type="submit" value="Posalji">
											</div>
										</form>
									</div>
								</div>

							</div>
						</div>
						<!--kraj dialoga za automobile-->


						<!--dialog za vesti-->
						<div id="myModal5" class="modal fade" role="dialog">
							<div class="dialogVesti modal-dialog">

								<!-- Modal content-->
								<div class="modal-content">
									<div class="vestiNaslov modal-header">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h3 class="modal-title">Vesti</h3>
									</div>

									<div class="vestiFooter modal-footer">
										<h3>Najnovija istrazivanja o sportskim automobilima</h3>
										<h5><b>Kompanija 1961. godine predstavlja model e-tajp, jedan od najpoznatijih sportskih automobila tog doba. Iste godine Jaguar kupuje Dajmler kompanija i proizvođača kamiona Guy Motors.</b></h5>
										<div class="vestiSlike">
											<img src="img/snowCar.jpg">
										</div>
										<p class="vestiTekst">Zatim, Jaguar preuzima 1963. godine kompaniju Coventry-Climax, koja je proizvodila viljuškare i motore. Pošto je bio zabrinut za budućnost kompanije, Vilijam Lajons 1966. godine donosi odluku o spajanju Jaguara sa Britiš motor
											korporacijom i tako stvaraju kompaniju pod nazivom Britiš motor holdings (BMH). Međutim, britanska vlada je 1968. godine BMH primorala da se integriše sa kompanijom Lejland motor, čime je formirana nova kompanija British Leyland.
											Međutim, spajanje između kompanija nije se pokazalo uspešno pa je 1975. godine razdvojeno. Jaguar postaje javna kompanija, ali se nedugo zatim suočio sa finansijskim poteškoćama, delom i zbog povlačenja osnivača Vilijama Lajonsa.
											Do 1984. godine kompanija je uspela da se vrati na tržište, ali nije bila u stanju da impresionira kao što je to činila u prošlosti. U periodu od 1984. do 1989. godine kompanija je bila nezavisni proizvođač automobila. I tada
											je kompanija imala problema, u prilog tome ide da je bilo otpušteno 10.000 radnika.</p>
										
										<?php
										 echo "<form method='POST' class='komentariBox'>
										 		<input type='hidden' name='id_comment' value='".$_SESSION['username']."'>
										 		<input type='hidden' name='date_comment' value='" .date('Y-m-d H:i:s'). "'>
												<input type='text' class='komentar' name='message' placeholder='Unesite komentar...' required>
												<button type='submit' name='submit_comment' class='komentarDugme'>Posalji</button>
											</form>";

										?>


										<h2>Komentari...</h2>

										<?php 
											getComments($conn);
										?>

										<!-- <div class="media">
											<div class="media-left">
												<img src="img/face1.jpg" class="media-object">
											</div>
											<div class="media-body">
												<h4 class="media-heading">Ivana Srnic     <small><i>Postavljeno: 19.05.2017</i></small></h4>
												<p>Intersuje me kako se ovi automobili ponasaju u zimskim uslovima?</p>

												<!-- Nested media object -->
												<!-- <div class="media">
													<div class="media-left">
														<img src="img/face3.jpg" class="media-object">
													</div>
													<div class="media-body">
														<h4 class="media-heading">Mladen A. <small><i>Odgovor: 11.09.2017</i></small></h4>
														<p>Licno sam imao iskustva sa ovakvim automobilima po svim vremenskim uslovima. Mogu vam reci da su odlicni.</p>
													</div>
												</div>

											</div>
										</div>
										<div class="media">
											<div class="media-left">
												<img src="img/face2.png" class="media-object">
											</div>
											<div class="media-body">
												<h4 class="media-heading">Anastasija R.<small><i>Postavljeno: 29.01.2018</i></small></h4>
												<p>Da li se jos mogu naci ovi automobili na domacem trzistu. Unapred hvala.</p>
											</div>
										</div>  -->
										
									</div>
								</div>
							</div>
						</div>






						<div id="sadrzaj">
							<div id="test">
								<h4>Testirani automobili</h4>
								<div class="slikaTekst col-lg-12">
									<div class="slika col-lg-5">
										<img src="img/audi1.jpg">
									</div>
									<div class="tekst col-lg-7">
										<p class="datum col-lg-4">29.10.2017.</p>
										<div class="sadrzajAuta col-lg-12">
											<h3 class="naslovAudi" data-toggle="modal" data-target="#myModal1">Audi 2016 Benzin 150KS 2.0 Germany</h3>
											<p> Jedan od najprodavanijih auta u danasnjem vremenskom periodu.
												<br>
												<br> Ocena: 9.44
											</p>
										</div>
									</div>
								</div>

								<div class="slikaTekst col-lg-12">
									<div class="slika col-lg-5">
										<img src="img/bmw1.jpg">
									</div>
									<div class="tekst col-lg-7">
										<p class="datum col-lg-4">19.10.2017.</p>
										<div class="sadrzajAuta col-lg-12">
											<h3 class="naslovBmw" data-toggle="modal" data-target="#myModal2">BMW 320i 2016 Benzin 210KS 2.6</h3>
											<p> Za udobnu i sportsku voznju. Predstavlja jedan od najboljih izdanja.
												<br>
												<br> Ocena: 9.25
											</p>
										</div>
									</div>
								</div>
								<div class="slikaTekst col-lg-12">
									<div class="slika col-lg-5">
										<img src="img/rover3.jpg">
									</div>
									<div class="tekst col-lg-7">
										<p class="datum col-lg-4">12.10.2017.</p>
										<div class="sadrzajAuta col-lg-12">
											<h3 class="naslovRover" data-toggle="modal" data-target="#myModal3">Rover 2015 Benzin 330KS 3.2 UK</h3>
											<p> Jedan od najprodavanijih auta u svakom smislu. Predstavlja pravi luksuzni auto.
												<br>
												<br> Ocena: 9.60
											</p>
										</div>
									</div>
								</div>
								<div class="slikaTekst col-lg-12">
									<div class="slika col-lg-5">
										<img src="img/audi3.png">
									</div>
									<div class="tekst col-lg-7">
										<p class="datum col-lg-4">11.06.2017.</p>
										<div class="sadrzajAuta col-lg-12">
											<h3 class="naslovAudiA8" data-toggle="modal" data-target="#myModal4">Audi A8 2017 Benzin 270KS 3.4</h3>
											<p> Audi A8 imao je svetsku premijeru na Audi samitu održanom u Barseloni.
												<br>
												<br> Ocena: 8.71
											</p>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div id="vesti" class="col-lg-3">
						<h3>Vesti</h3>
						<p><a href="#" data-toggle="modal" data-target="#myModal5">Najnovija istrazivanja o sportskim automobilima</a></p>
						<p><a href="#" data-toggle="modal" data-target="#myModal5">Projektovanje sistema za samostalno ubrzavanje</a></p>
						<p><a href="#" data-toggle="modal" data-target="#myModal5">Koje je najbolje vreme za vas automobil</a></p>
						<p><a href="#" data-toggle="modal" data-target="#myModal5">Sta treba znati o starosti automobila</a></p>
						<p><a href="#" data-toggle="modal" data-target="#myModal5">Kako porediti jačinu motora sa kubikažom koju auto ima</a></p>
						<p><a href="#" data-toggle="modal" data-target="#myModal5">Pogledajte kako izgleda unutrašjost Formule 1</a></p>
						<p><a href="#" data-toggle="modal" data-target="#myModal5">Sajam automobila Ženeva 2017. godine</a></p>
						<div class="josVesti">
							<p><a href="#" data-toggle="modal" data-target="#myModal5">Pobednik trke Dakar 2016 Finac Mikhayren Filto</a></p>
							<!--Vidi jos text-->
							<p><a href="#" data-toggle="modal" data-target="#myModal5">Pogledajte najbolje automobile u periodu od 1950-1970</a></p>
							<p><a href="#" data-toggle="modal" data-target="#myModal5">Pobednik MotoGP trke u Bahreinu Italijan Valentino Rosi</a></p>
						</div>
						<p class="vidiJos">&darr;Vidi jos</p>
						<p class="vidiManje">Vidi manje &uarr; </p>
					</div>
				</div>
			</div>
		</div>
		<!--kraj sadrzaja-->


		<!--pocetak testiranja-->
		<div id="autoTest">
			<div class="naslovTest">
				<h3>Najbolje ocenjeni automobili</h3>
			</div>
			<div class="sadrzajTest">
				<div class="honda">
					<img src="img/mala1.jpg">
					<h5>Honda</h5>
					<ul class="vrsteAuta">
						<li><a href="http://www.honda.com/">Hr-V</a></li>
						<li><a href="http://www.honda.com/">Pilot</a></li>
						<li><a href="http://www.honda.com/">Civic</a></li>
						<li><a href="http://www.honda.com/">Accord</a></li>
						<li><a href="http://www.honda.com/">NSX</a></li>
					</ul>
				</div>

				<div class="toyota">
					<img src="img/mala2.jpg">
					<h5>Toyota</h5>
					<ul class="vrsteAuta">
						<li><a href="https://www.toyota.com/">Avalon</a></li>
						<li><a href="https://www.toyota.com/">Camry</a></li>
						<li><a href="https://www.toyota.com/">Highlander</a></li>
						<li><a href="https://www.toyota.com/">Prius</a></li>
						<li><a href="https://www.toyota.com/">Sienna</a></li>
					</ul>
				</div>

				<div class="bmw">
					<img src="img/bmw5.jpg">
					<h5>BMW</h5>
					<ul class="vrsteAuta">
						<li><a href="https://www.bmwusa.com/">3. Series</a></li>
						<li><a href="https://www.bmwusa.com/">M135i</a></li>
						<li><a href="https://www.bmwusa.com/">M2</a></li>
						<li><a href="https://www.bmwusa.com/">4 Series Coupe</a></li>
						<li><a href="https://www.bmwusa.com/">i3</a></li>
					</ul>
				</div>


				<div class="audi">
					<img src="img/audi5.jpg">
					<h5>Audi</h5>
					<ul class="vrsteAuta">
						<li><a href="https://www.audiusa.com">RS6</a></li>
						<li><a href="https://www.audiusa.com">A8</a></li>
						<li><a href="https://www.audiusa.com">Q5</a></li>
						<li><a href="https://www.audiusa.com">Q7</a></li>
						<li><a href="https://www.audiusa.com">TT Roadster</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<!--pocetak 2 strane-->

	<div id="strana2" class="tab-pane fade">
		<div class="row">
			<div class="col col-lg-12">
				<h1 id="ONamaNaslov">O nama</h1>
			</div>

			<div class="col col-lg-12" id="ONamaSadrzaj">
				<h4><u>Zašto baš CarTest i po čemu se to mi razlikujemo od ostalih?</u></h4>
				<br>
				<p>Ideja oko osnivanja CarTest-a i foruma nastala je kao projekat zaljubljenika u automobile. Realno skoro svaki auto brend poseduje svoj klub, skoro u svim zemljama Zapadnog Balkana, međutim da li postoji mesto koje objedinjuje sve klubove?
					Ako ne postoji mi ćemo ga obezbediti. Uvidevši sve to došli smo na ideju da osnujemo forum i portal, koji će obezbediti mesto svima zaljubljenicima u automobilizam. Gde će Alfisa u korak sa Seatovcem moći da komentariše obe strane, bez svađe
					sa podjednakom željom da razmene iskustva. Želja nam je da CarTest bude mesto istinskih ljubitelja automobila, koji će po registraciji da se vrate na forum i da prate sadržaje na našem portalu iz razloga što će biti sa ljudima koji dele
					isti stav koji kaže –automobil nije samo prevozno sredstvo.
				</p>
				<br>
				<h4><u>Naša misija.</u></h4>
				<br>
				<p>Naša misija je da obezbedimo mesto za sve one ljude koji su voljni da razmenjuju znanje, ljubav i strast prema automobilima i automobilizmu u opšte. Želimo da olakšamo put pravim ljubiteljima automobila koji se tek upoznaju sa automobilskim
					tehnologijama i terminima, i svima onima koju su već na tom putu.
				</p>
				<br>
				<h4><u>Tu smo zbog vas!</u></h4>
				<br>
				<p>Jednostavno CarTest je mesto za sve one, još jednom, kojima automobil nije samo prevozno sredstvo, DOK JE PORTAL I FORUM AUTOMOBILI mesto ljubitelja automobila svih brendova. Da li ste želeli takvo mesto? Ako jeste, obezbedićemo ga za Vas!
				</p>
			</div>
			<div class="col-lg-10" id="galerija">
				<!-- start brands -->
				<div id="brands">
					<div id="brandsHeader">
						<p>Strani i domaci</p>
						<h2>Brendovi</h2>
						<span id="brandsDescription">Ovo su najpoznatiji brendovi<br>koje je nasa firma testirala.</span>
					</div>
					<div id="brandsType">
						<table>
							<tr class="tableRow">
								<td>
									<p>Hyundai</p>
									<a href="https://www.hyundaiusa.com/"><img src="img/hyundai.png" /></a>
								</td>
								<td>
									<p>Ford</p>
									<a href="http://www.ford.com/"> <img src="img/ford.png" /></a>
								</td>
								<td>
									<p>Honda</p>
									<a href="http://www.honda.com/"> <img src="img/honda.jpg" /></a>
								</td>
							</tr>

							<tr class="tableRow">
								<td>
									<p>Volvo</p>
									<a href="http://www.volvo.com/home.html"><img src="img/volvo.png" /></a>
								</td>
								<td>
									<p>BMW</p>
									<a href="https://www.bmwusa.com/"><img src="img/bmwB.jpg" /></a>
								</td>
								<td>
									<p>Mercedes-Bens</p>
									<a href="https://www.mbusa.com/mercedes/index"><img src="img/mercedes.jpg" /></a>
								</td>
							</tr>

							<tr class="tableRow">
								<td>
									<p>Porsche</p>
									<a href="https://www.porsche.com/"><img src="img/porcshe.png" /></a>
								</td>
								<td>
									<p>Kia</p>
									<a href="https://www.cars.com/research/kia/"><img src="img/kia.png" /></a>
								</td>
								<td>
									<p>Audi</p>
									<a href="https://www.audiusa.com"><img src="img/audiB.jpg" /></a>
								</td>
							</tr>
						</table>
					</div>
					<!-- end brands -->
				</div>
			</div>
		</div>
	</div>


	<!--pocetak 3 strane-->

	<div id="strana3" class="tab-pane fade">
		<div class="row">
			<div class="col-lg-12">
				<h1 id="KontaktNaslov">Kontakt</h1>
			</div>
			<div class="col-lg-12" id="mapa">
				<div class="col-lg-6" id="KontaktLevo">
					<p>Adresa: Beogradska Aleksandra Medvedeva 20, Nis 18000
						<br> Telefon: +381 18 545 849, 545 684, 545 333
						<br> Mail: cartest@gmail.com
						<br> Ponedeljak-Petak: 10h-18h </p>
					<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d862.8431502231589!2d21.889245308263483!3d43.330023383732026!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xb6c8bdf48775d64e!2z0JLQuNGB0L7QutCwINCi0LXRhdC90LjRh9C60LAg0KjQutC-0LvQsA!5e0!3m2!1sen!2srs!4v1480877341176"
							width="100%" height="450" frameborder="0" style="border:0"></iframe>
				</div>
				<div class="col-lg-6" id="KontaktDesno">
					<form name="forma" id="form">
						<input class="polje1" required placeholder="Unesite ime...">
						<br>
						<input class="polje2" required type="email" placeholder="Unesite mail...">
						<br>
						<textarea rows="9" class="polje3" required placeholder="Unesite poruku..."></textarea>
						<br>
						<input type="submit" id="KontaktDugme" value="Pošalji">
					</form>
				</div>
			</div>
			<div id="news">
				<div id="Newsletter">
					<h1>Newsletter</h1>
					<p>Primaj obaveštenje o ocenama i ostalim novostima</p>
				</div>
				<form id="NewsForm">
					<i><input type="email" placeholder="Vaša e-mail adresa"></i>
					<br>
					<input type="submit" id="NewsButton" value="Pošalji">
				</form>
			</div>
		</div>
	</div>
</div>
<!--kraj testiranja-->

<!--Pocetak footer-->
<footer>
	<div class="mreze">
		<ul>
			<li><img src="img/fb.png"><a href="https://www.facebook.com/">Facebook</a></li>
			<li><img src="img/twitter.png"><a href="https://twitter.com/">Twitter</a></li>
			<li><img src="img/youtube.png"><a href="https://www.youtube.com/">Youtube</a></li>
			<li><img src="img/inst.png"><a href="https://www.instagram.com/">Instagram</a></li>

		</ul>
	</div>
	<div class="footer">
		<div>
			<h6>Najnovije</h6>
			<ul class="sadrzajFooter">
				<li><a href="#">Automobili</a></li>
				<li><a href="#">Stara vozila</a></li>
				<li><a href="#">Nova vozila</a></li>
				<li><a href="#">Registrovanje</a></li>
				<li><a href="#">Posao</a></li>
			</ul>
		</div>
		<div>
			<h6>Vesti</h6>
			<ul class="sadrzajFooter">
				<li><a href="#">Putovanja</a></li>
				<li><a href="#">Vreme</a></li>
				<li><a href="#">Nove rute</a></li>
				<li><a href="#">Autoput E75</a></li>
				<li><a href="#">Preko Ibarske</a></li>
			</ul>
		</div>
		<div>
			<h6>Najčitanije</h6>
			<ul class="sadrzajFooter">
				<li><a href="#">Top 10 auta</a></li>
				<li><a href="#">Ferrari</a></li>
				<li><a href="#">Auto budućnosti</a></li>
				<li><a href="#">Krediti</a></li>
				<li><a href="#">Uvozni automobili</a></li>
			</ul>
		</div>
	</div>
	<p>Copyright &copy; 2017 - Powered by <a href="#">CarTest</a></p>
</footer>
<!--kraj footer-->
</body>

</html>
