<?php

/**
 * Classe qui gère les articles.
 */
class ArticleManager extends AbstractEntityManager
{
    /**
     * Récupère tous les articles.
     * @return array : un tableau d'objets Article.
     */
    public function getAllArticles(): array
    {
        $sql = "SELECT * FROM article";
        $result = $this->db->query($sql);
        $articles = [];

        while ($article = $result->fetch()) {
            $articles[] = new Article($article);
        }
        return $articles;
    }

    /**
     * Récupère un article par son id.
     * @param int $id : l'id de l'article.
     * @return Article|null : un objet Article ou null si l'article n'existe pas.
     */
    public function getArticleById(int $id): ?Article
    {
        $sql = "SELECT * FROM article WHERE id = :id";
        $result = $this->db->query($sql, ['id' => $id]);
        $article = $result->fetch();
        if ($article) {
            return new Article($article);
        }
        return null;
    }

    /**
     * Ajoute ou modifie un article.
     * On sait si l'article est un nouvel article car son id sera -1.
     * @param Article $article : l'article à ajouter ou modifier.
     * @return void
     */
    public function addOrUpdateArticle(Article $article): void
    {
        if ($article->getId() == -1) {
            $this->addArticle($article);
        } else {
            $this->updateArticle($article);
        }
    }

    /**
     * Ajoute un article.
     * @param Article $article : l'article à ajouter.
     * @return void
     */
    public function addArticle(Article $article): void
    {
        $sql = "INSERT INTO article (id_user, title, content, date_creation, date_update, nb_vue) VALUES (:id_user, :title, :content, NOW(), NOW(), 0)";
        $this->db->query($sql, [
            'id_user' => $article->getIdUser(),
            'title' => htmlspecialchars($article->getTitle()),  // Ajout function pour eviter faille XSS
            'content' => htmlspecialchars($article->getContent())
        ]);
    }

    /**
     * Modifie un article.
     * @param Article $article : l'article à modifier.
     * @return void
     */
    public function updateArticle(Article $article): void
    {
        $sql = "UPDATE article SET title = :title, content = :content, date_update = NOW() WHERE id = :id";
        $this->db->query($sql, [
            'title' => htmlspecialchars($article->getTitle()),  // Ajout function pour eviter faille XSS
            'content' => htmlspecialchars($article->getContent()),
            'id' => $article->getId()
        ]);
    }

    /**
     * Supprime un article.
     * @param int $id : l'id de l'article à supprimer.
     * @return void
     */
    public function deleteArticle(int $id): void
    {
        $sql = "DELETE FROM article WHERE id = :id";
        $this->db->query($sql, ['id' => $id]);
    }

    /**
     * Ajout methode pour incrémenter le nb de vue sur chaque article
     * @param Article $article
     * @return void
     */
    public function updateNbVueArticle(Article $article): void
    {
        $sql = "UPDATE article SET nb_vue = :nb_vue WHERE id = :id";
        $this->db->query($sql, [
            'nb_vue' => $article->getNbVue(),
            'id' => $article->getId()
        ]);
    }

    /**
     * Selectionne le titre d'un article grâce à son id
     * @param int $id
     */
    public function getArticleTitleById(int $id): array
    {
        $sql = "SELECT title FROM article WHERE id= :id";
        $result = $this->db->query($sql, ['id' => $id]);

        return $result->fetch();
    }

}