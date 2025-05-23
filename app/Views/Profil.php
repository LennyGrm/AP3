<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="/css/stylesProfil.css"> 
</head>
<body>

<?php
$id = session()->get('id');
echo "<h1>" . $id . "</h1>";

$db = \Config\Database::connect();

try {
    $builder = $db->table('Adherent');
    $builder->select('idAdherent');
    $builder->where('identifiant', $id);
    $adherent = $builder->get()->getRow();

    if ($adherent) {
        $idAdherent = $adherent->idAdherent;

        $builder = $db->table('Entraineur');
        $builder->where('idAdherent', $idAdherent);
        $entraineur = $builder->get()->getRow();

        $builder = $db->table('Joueur');
        $builder->where('idAdherent', $idAdherent);
        $joueur = $builder->get()->getRow();

        if ($entraineur) {

            ?>
                <h1>Page Entraineur</h1>
            <?php
            $sql = "EXEC dbo.NbHeureEntrainementJoueurs";
            $query = $db->query($sql);
            $results = $query->getResult();
            
            echo "<table border='1'>";
            echo "<tr><th>Prénom</th><th>Nom</th><th>Heures d'entraînement</th></tr>";
            foreach ($results as $row) {
                echo "<tr>";
                echo "<td>" . $row->prenom. "</td>";
                echo "<td>" . $row->nom. "</td>";
                echo "<td>" . $row->heuresEntrainement . "</td>";
                echo "</tr>";
            }
            echo "</table>";
?>
<?php
        }
        elseif ($joueur) {

            ?>
                <h1>Page Joueur</h1>
            <?php 
            $sql = "SELECT * FROM Joueur JOIN Adherent ON Joueur.idAdherent = Adherent.idAdherent";
            $query = $db->query($sql);
            $results = $query->getResult();
            
            echo "<table border='1'>";
            echo "<tr><th>Prénom</th><th>Nom</th><th>date de Naissance</th><th>Poste</th></tr>";
            foreach ($results as $row) {
                echo "<tr>";
                echo "<td>" . $row->prenom. "</td>";
                echo "<td>" . $row->nom. "</td>";
                echo "<td>" . $row->dateNaissance . "</td>";
                echo "<td>" . $row->poste . "</td>";
                echo "</tr>";
            }
            echo "</table>";     

            $sql = "SELECT * FROM Rencontre JOIN Evenement ON Rencontre.idEvenement = Evenement.idEvenement";
            $query = $db->query($sql);
            $results = $query->getResult();
            
            echo "<table border='1'>";
            echo "<tr><th>Lieu</th><th>Division</th><th>Adversaire</th><th>Score</th></tr>";
            foreach ($results as $row) {
                echo "<tr>";
                echo "<td>" . $row->lieu. "</td>";
                echo "<td>" . $row->division. "</td>";
                echo "<td>" . $row->Adversaire . "</td>";
                echo "<td>" . $row->Score . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
        else{
            ?>
                <h1>Page Invité</h1>
                
            <?php
        }
    }
} catch (\Exception $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
    <a class='deconnecter' href=<?php echo(base_url('Logout')) ?>>Se déconnecter</a>


</body>
</html>
