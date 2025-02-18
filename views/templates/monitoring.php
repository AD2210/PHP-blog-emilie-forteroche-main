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
                        <a href="index.php?action=showMonitoring&order=title&direction=ASC">crois</a>
                        <a href="index.php?action=showMonitoring&order=title&direction=DESC">decrois</a>
                    </div>
                </div>      
            </th>
            <th scope="col">
                <div class="headLine">    
                    <div>Publié le</div>
                    <div>
                        <a href="index.php?action=showMonitoring&order=date_creation&direction=ASC">crois</a>
                        <a href="index.php?action=showMonitoring&order=date_creation&direction=DESC">decrois</a>
                    </div>
                </div>
            </th>
            <th scope="col">
                <div class="headLine">    
                    <div>Vues</div>
                    <div>
                        <a href="index.php?action=showMonitoring&order=nb_vue&direction=ASC">crois</a>
                        <a href="index.php?action=showMonitoring&order=nb_vue&direction=DESC">decrois</a>
                    </div>
                </div>
            </th>
            <th scope="col">
                <div class="headLine">    
                    <div>Commentaires</div>
                    <div>
                        <a href="index.php?action=showMonitoring&order=nb_comment&direction=ASC">crois</a>
                        <a href="index.php?action=showMonitoring&order=nb_comment&direction=DESC">decrois</a>
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