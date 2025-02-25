<?php
/**
 * Affichage de Liste des articles. 
 */
?>

<div class="articleList">
    <?php foreach ($articles as $article) {
        $title = $article->getTitle();
        $articleContent = $article->getContent(400);
        $dateCreation = ucfirst(Utils::convertDateToFrenchFormat($article->getDateCreation()));
        $id = $article->getId();

        // Heredoc pour afficher les variables récupérés
        $showArticle = <<<ARTICLE
            <article class="article">
                <h2>$title</h2>
                <span class="quotation">«</span>
                <p>$articleContent</p>

                <div class="footer">
                    <span class="info">$dateCreation</span>
                    <a class="info" href="index.php?action=showArticle&id=$id">Lire +</a>
                </div>
            </article> 
        ARTICLE;
        echo $showArticle;
    }
    ?>
</div>