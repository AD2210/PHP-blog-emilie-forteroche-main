<?php
/** 
 * Affichage de la partie admin : liste des articles avec un bouton "modifier" pour chacun. 
 * Et un formulaire pour ajouter un article. 
 */
?>

<h2>Edition des articles</h2>

<div class="adminArticle">
    <?php
    //Variable permettant d'avoir le numero de ligne et différencier l'affichage des lignes paire et impaire grace à leur classe respective
    $i = 0;
    foreach ($articles as $article) {
        $i++;
        $colorLine = ($i % 2 == 0) ? 'lignePaire' : 'ligneImpaire';
        $title = $article->getTitle();
        $content = $article->getContent(200);
        $id = $article->getId();
        $confirmation = Utils::askConfirmation("Êtes-vous sûr de vouloir supprimer cet article ?");
        
        // PHP Heredoc pour afficher les variables récupérés.
        $showArticle = <<<ARTICLE
            <div class="articleLine $colorLine">
                <div class="title">$title</div>
                    <div class="content">$content</div>
                    <div><a class="submit" href="index.php?action=showUpdateArticleForm&id=$id">Modifier</a></div>
                    <div>
                        <a class="submit" href="index.php?action=deleteArticle&id=$id" $confirmation>Supprimer</a>
                </div>
            </div>
            ARTICLE;
        echo $showArticle;
    } ?>
</div>

<div class="navAdmin">
    <a class="submit" href="index.php?action=showUpdateArticleForm">Ajouter un article</a>
    <a class="submit" href="index.php?action=showMonitoring">Afficher les statistiques</a>
</div>