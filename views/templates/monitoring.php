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
            <th scope="col">
                <div class="headLine">
                    <div>Titre</div>
                    <div class ="filterButton">
                        <a href="index.php?action=showMonitoring&order=title&direction=ASC">↑</a>
                        <a href="index.php?action=showMonitoring&order=title&direction=DESC">↓</a>
                    </div>
                </div>
            </th>
            <th scope="col">
                <div class="headLine">
                    <div>Publié le</div>
                    <div class ="filterButton">
                        <a href="index.php?action=showMonitoring&order=date_creation&direction=ASC">↑</a>
                        <a href="index.php?action=showMonitoring&order=date_creation&direction=DESC">↓</a>
                    </div>
                </div>
            </th>
            <th scope="col">
                <div class="headLine">
                    <div>Vues</div>
                    <div class ="filterButton">
                        <a href="index.php?action=showMonitoring&order=nb_vue&direction=ASC">↑</a>
                        <a href="index.php?action=showMonitoring&order=nb_vue&direction=DESC">↓</a>
                    </div>
                </div>
            </th>
            <th scope="col">
                <div class="headLine">
                    <div>Commentaires</div>
                    <div class ="filterButton">
                        <a href="index.php?action=showMonitoring&order=nb_comment&direction=ASC">↑</a>
                        <a href="index.php?action=showMonitoring&order=nb_comment&direction=DESC">↓</a>
                    </div>
                </div>
            </th>
        </tr>
    </thead>
    <tbody>

        <?php
        //Variable permettant d'avoir le numero de ligne et différencier l'affichage des lignes paire et impaire grace à leur classe respective
        $i = 0;
        foreach ($datas as $data) {
            $i++;
            $colorLine = ($i % 2 == 0) ? 'lignePaire' : 'ligneImpaire';
            $title = $data['title'];
            $nbVue = $data['nb_vue'];
            $nbComment = $data['nb_comment'];
            $id = $data['id'];
            $dateCreation = Utils::convertDateToFrenchFormat($data['date_creation']);

            // HereDoc pour afficher les variables récupérés
            $tableLine = <<<TABLE
                <tr class="tableLine $colorLine">
                    <th scope="row" class="title">$title</th>
                    <td>$dateCreation</td>
                    <td>$nbVue</td>
                    <td>
                        <div class="com">
                            $nbComment
                            <a class="submit" href="index.php?action=commentManagement&id=$id">Gerer</a>
                        </div>
                    </td>
                </tr>
            TABLE;
            echo $tableLine;
        } ?>
    </tbody>
</table>

<div class="navAdmin">
    <a class="submit" href="index.php?action=admin">Gestion des articles</a>
</div>