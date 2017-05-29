<!doctype html>
<html>

	<head>
		<meta charset="UTF-8">
		<title>#HvisJegVarBorgmester</title>
		
		<link href="styles1.css" rel="stylesheet">
		
		<script src="java.js"></script>
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        
        <meta name="viewport" content="width=device-width, initial-scale=1">
	</head>
    
    <body>
        <?php 
			require_once('db.php');
		
		
			$filter = array(
			'navn'=> FILTER_UNSAFE_RAW,
            'overskrift'=>FILTER_UNSAFE_RAW,
			'indlag'=> FILTER_UNSAFE_RAW,
			'cmd'=> FILTER_SANITIZE_STRING,
			'indlag_id'=> FILTER_UNSAFE_RAW,
            'k_navn'=> FILTER_UNSAFE_RAW,
            'kommentar' => FILTER_UNSAFE_RAW   
			);
	
			$formArray = filter_input_array(INPUT_POST, $filter);
	
			$navn = $formArray['navn'];
            $overskrift = $formArray['overskrift'];
			$indlag = $formArray['indlag'];
			$cmd = $formArray['cmd'];
			$id = $formArray['indlag_id'];
            $k_navn = $formArray['k_navn'];
            $kommentar = $formArray['kommentar'];
		
		
		
		switch($cmd) {
			case 'Opret indlæg':
				require_once('db.php');
				$sql = 'INSERT INTO borgmester (navn, overskrift, indlag) VALUES (?, ?, ?)';
				$stmt = $con->prepare($sql);
				$stmt->bind_param('sss', $navn, $overskrift, $indlag);
				$stmt->execute();			

				break;
            
            case 'Send':
				require_once('db.php');
				$sql = 'INSERT INTO kommentarer (k_navn, kommentar, indlag_id) VALUES (?, ?, ?)';
				$stmt1 = $con->prepare($sql);
				$stmt1->bind_param('ssi', $k_navn, $kommentar, $id);
				$stmt1->execute();
                
                break;
				default;
		}
	
		?>
        
        
        
        
        <div class="header">
            <a href="index.html"><img src="logo.png" alt="logo"></a>
            
            <nav class="computer">
                <ul>
                    <li><a href="index.html">FORSIDE</a></li>|
                    <li><a href="forum.php" class="valg">FORUM</a></li>|
                    <li><a href="minborgmester1.html">MIN BORGMESTER</a></li>
                </ul>
            </nav>
        </div>
        
        
        <div class="container_forum">    
            <h1>FORUM</h1>
            
            <button class="tilfoj">OPRET INDLÆG</button>
            <div class="add">
                <div>
                    <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
                        
                        <h3>OPRET INDLÆG</h3><br>
                        <h4>Overskrift:</h4>
                        <input type="text" name="overskrift" required>
                        <h4>Navn:</h4>
                        <input type="text" name="navn" required>
                        <h4>Indlæg:</h4>
                        <textarea rows="15" cols="35" name="indlag" required></textarea><br><br>
                        <input type="submit" name="cmd" value="Opret indlæg">
                        
                    </form>
                </div>
            </div>
        </div>
        
        
        
        
        
        
        <div class="container_indlag">
            <?php
            $stmt = $con->prepare('SELECT indlag_id, overskrift, navn, dato, indlag FROM borgmester ORDER  BY dato DESC');
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($id, $overskrift1, $navn1, $dato, $indlag1);
                          
    
            while($stmt->fetch()) {
			echo '<div class="indlag">';
                echo '<h2>'. $overskrift1.  '</h2>';
                echo '<h3>'. $navn1. ' // '. $dato. '</h3>';
            
                echo '<div class="tekst">';
                    echo '<p>'. $indlag1. '</p>';
                echo '</div>';
               
                
                
            $stmt2 = $con->prepare("SELECT k_navn, kommentar FROM kommentarer WHERE indlag_id='$id'");
            $stmt2->execute();
            $stmt2->bind_result($k_navn1, $kommentar1);
    
              
                
                
            echo '<div class="kommentarer">';   
            while($stmt2->fetch()) {
                echo '<p><strong>' .$k_navn1. ': </strong>'. $kommentar1. '</p><br>';
            }
                
                
                
                    echo '<form action="'.$_SERVER['PHP_SELF'].'" method="post">';
                    echo '<textarea class="kommentar_tekst" rows="1" cols="15" name="k_navn" required placeholder="Navn"></textarea>';
                    echo '<textarea rows="1" cols="23" name="kommentar" required placeholder="Kommentar"></textarea>';
                    echo '<input type="hidden" name="indlag_id" value="'. $id. '">';
                    echo '<br>';
                    echo '<input type="submit" name="cmd" value="Send">';
                    echo '</form>';
                
                echo '</div>';
            
            echo '</div>';
            }
            $con->close();               
            ?>
            
		</div>
        
        
        
        
        
        
        <footer>
            <p>HUSK at deltage i konkurrencen på Instagram</p>
            <i class="fa fa-arrow-right" aria-hidden="true"></i>
            <img src="instagram.png" alt="instagram">
        </footer>
        
        
        
        <script src="js.js"></script>
        <script src="java.js"></script>
    </body>