<?php 
    /** 
     * Affichage de la partie monitoring : liste des articles avec le nb de vues, le nb de commentaire et la date de publication. 
     * 
     */
?>

<h2>Statistiques des articles</h2>

<div>
    <table class="tableMonitoring">
        <thead>
            <tr class="tableLine">
                <th scope="col">Titre</th>
                <th scope="col">Publié le</th>
                <th scope="col">Nb de vue</th>
                <th scope="col">Nb de com</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($articles as $article) { ?>
            <tr class="tableLine">
                <th scope="row" class="title"><?= $article->getTitle() ?></th>
                <td><?= Utils::convertDateToFrenchFormat($article->getDateCreation()) ?></td>
                <td><?= $article->getNbVue() ?></td>
                <td><?= count($commentManager->getAllCommentsByArticleId($article->getId())) ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    
</div>
