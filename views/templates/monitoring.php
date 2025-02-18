<?php 
    /** 
     * Affichage de la partie monitoring : liste des articles avec le nb de vues, le nb de commentaire et la date de publication. 
     * 
     */
?>

<h2>Statistiques des articles</h2>

<table class="tableMonitoring">
    <thead>
        <tr class="tableLine">
            <th  scope="col">
                <div class="headLine">  
                    <div>Titre</div>
                    <div>
                        <a href="#">crois</a>
                        <a href="#">decrois</a>
                    </div>
                </div>      
            </th>
            <th scope="col">
                <div class="headLine">    
                    <div>Publié le</div>
                    <div>
                        <a href="#">crois</a>
                        <a href="#">decrois</a>
                    </div>
                </div>
            </th>
            <th scope="col">
                <div class="headLine">    
                    <div>Vues</div>
                    <div>
                        <a href="#">crois</a>
                        <a href="#">decrois</a>
                    </div>
                </div>
            </th>
            <th scope="col">
                <div class="headLine">    
                    <div>Commentaires</div>
                    <div>
                        <a href="#">crois</a>
                        <a href="#">decrois</a>
                    </div>
                </div>
            </th>
        </tr>
    </thead>
    <tbody>
        
        <?php 
        foreach ($datas as $data) { ?>
        <tr class="tableLine">
            <th scope="row" class="title"><?= $data['title'] ?></th>
            <td><?= Utils::convertDateToFrenchFormat($data['date_creation']) ?></td>
            <td><?= $data['nb_vue'] ?></td>
            <td><?= $data['nb_comment'] ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>

<div class="navAdmin">
    <a class="submit" href="index.php?action=admin">Gestion des articles</a>
</div>