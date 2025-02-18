<?php 
/**
 * Contrôleur de la partie admin.
 */
 
class AdminController {

    /**
     * Affiche la page d'administration : Edition des articles.
     * @return void
     */
    public function showAdmin() : void
    {
        // On vérifie que l'utilisateur est connecté.
        $this->checkIfUserIsConnected();

        // On récupère les articles.
        $articleManager = new ArticleManager();
        $articles = $articleManager->getAllArticles();

        // On affiche la page d'edition des artciles'.
        $view = new View("Administration");
        $view->render("admin", [
            'articles' => $articles
        ]);
    }

    /**
     * Affiche la page d'administration : Monitoring.
     * @return void
     */
    public function showMonitoring() : void
    {
        // On vérifie que l'utilisateur est connecté.
        $this->checkIfUserIsConnected();

        //On récupère les variables passées dans l'url
        $order = Utils::request('order', 'title'); //ajout parametre order et direction pour filtre du tableau de stats
        $direction = Utils::request('direction', 'ASC');

        // On récupère les articles.
        $articleManager = new ArticleManager();
        $commentManager = new CommentManager();
        $articles = $articleManager->getAllArticles();

        //contruction du tableau de data associé avec les différentes tables utilisés :
        //Article et commentaires
        foreach ($articles as $article){
            $datas[]=[
                'id' => $article->getId(),
                'title' => $article->getTitle(),
                'date_creation' => $article->getDateCreation(),
                'nb_vue' => $article->getNbVue(),
                'nb_comment' => count($commentManager->getAllCommentsByArticleId($article->getId()))
            ];
        }

        // tri parametré de notre tableau avec Multisort qui a l'avantage de garder les correspondance dans un tableau multidim
        $direction = $direction == 'DESC' ? SORT_DESC : SORT_ASC; // définition de l'ordre du tri, ASC par défaut
        $title = array_column($datas,'title'); //on tranforme le tableau de ligne en tableau de colonne pour multisort
        $date_creation = array_column($datas,'date_creation');
        $nb_vue = array_column($datas,'nb_vue');
        $nb_comment = array_column($datas,'nb_comment');

        switch ($order){ // le switch permet de choisir le parametre de tri : 1er arg de multisort
            // tri par titre
            case 'title' :
                array_multisort($title,$direction,$date_creation,$nb_vue,$nb_comment,$datas);
                break;
            // tri par date de creation
            case 'date_creation' :
                array_multisort($date_creation,$direction,$title,$nb_vue,$nb_comment,$datas);
                break;
            //trie par nb de vue
            case 'nb_vue' :
                array_multisort($nb_vue,$direction,$title,$date_creation,$nb_comment,$datas);
                break;
            //trie par nb de commentaire
            case 'nb_comment' :
                array_multisort($nb_comment,$direction,$title,$nb_vue,$date_creation,$datas);
                break;
            
            default:
            array_multisort($title,$direction,$date_creation,$nb_vue,$nb_comment,$datas);
        }

        // On affiche la page de monitoring avec le tableau trié en fonction de la demande utilisateur.
        $view = new View("Monitoring");
        $view->render("monitoring", [
            'datas' => $datas
        ]);
    }

    public function commentManagement() : void
    {
        // On vérifie que l'utilisateur est connecté.
        $this->checkIfUserIsConnected();

        //On récupère les variables passées dans l'url
        $id = Utils::request('id', -1);

        // On récupère les titres des articles les commentaires.
        $articleManager = new ArticleManager();
        $commentManager = new CommentManager();
        $article = $articleManager->getArticleTitleById(intval($id));
        $comments = $commentManager->getAllCommentsByArticleId(intval($id));

        // On affiche la page d'edition des artciles'.
        $view = new View("Administration");
        $view->render("commentManagement", [
            'comments' => $comments,
            'article' => $article
        ]);
    }

    /**
     * Vérifie que l'utilisateur est connecté.
     * @return void
     */
    private function checkIfUserIsConnected() : void
    {
        // On vérifie que l'utilisateur est connecté.
        if (!isset($_SESSION['user'])) {
            Utils::redirect("connectionForm");
        }
    }

    /**
     * Affichage du formulaire de connexion.
     * @return void
     */
    public function displayConnectionForm() : void 
    {
        $view = new View("Connexion");
        $view->render("connectionForm");
    }

    /**
     * Connexion de l'utilisateur.
     * @return void
     */
    public function connectUser() : void 
    {
        // On récupère les données du formulaire.
        $login = Utils::request("login");
        $password = Utils::request("password");

        // On vérifie que les données sont valides.
        if (empty($login) || empty($password)) {
            throw new Exception("Tous les champs sont obligatoires. 1");
        }

        // On vérifie que l'utilisateur existe.
        $userManager = new UserManager();
        $user = $userManager->getUserByLogin($login);
        if (!$user) {
            throw new Exception("L'utilisateur demandé n'existe pas.");
        }

        // On vérifie que le mot de passe est correct.
        if (!password_verify($password, $user->getPassword())) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            throw new Exception("Le mot de passe est incorrect : $hash");
        }

        // On connecte l'utilisateur.
        $_SESSION['user'] = $user;
        $_SESSION['idUser'] = $user->getId();

        // On redirige vers la page d'administration.
        Utils::redirect("admin");
    }

    /**
     * Déconnexion de l'utilisateur.
     * @return void
     */
    public function disconnectUser() : void 
    {
        // On déconnecte l'utilisateur.
        unset($_SESSION['user']);

        // On redirige vers la page d'accueil.
        Utils::redirect("home");
    }

    /**
     * Affichage du formulaire d'ajout d'un article.
     * @return void
     */
    public function showUpdateArticleForm() : void 
    {
        $this->checkIfUserIsConnected();

        // On récupère l'id de l'article s'il existe.
        $id = Utils::request("id", -1);

        // On récupère l'article associé.
        $articleManager = new ArticleManager();
        $article = $articleManager->getArticleById($id);

        // Si l'article n'existe pas, on en crée un vide. 
        if (!$article) {
            $article = new Article();
        }

        // On affiche la page de modification de l'article.
        $view = new View("Edition d'un article");
        $view->render("updateArticleForm", [
            'article' => $article
        ]);
    }

    /**
     * Ajout et modification d'un article. 
     * On sait si un article est ajouté car l'id vaut -1.
     * @return void
     */
    public function updateArticle() : void 
    {
        $this->checkIfUserIsConnected();

        // On récupère les données du formulaire.
        $id = Utils::request("id", -1);
        $title = Utils::request("title");
        $content = Utils::request("content");

        // On vérifie que les données sont valides.
        if (empty($title) || empty($content)) {
            throw new Exception("Tous les champs sont obligatoires. 2");
        }

        // On crée l'objet Article.
        $article = new Article([
            'id' => $id, // Si l'id vaut -1, l'article sera ajouté. Sinon, il sera modifié.
            'title' => $title,
            'content' => $content,
            'id_user' => $_SESSION['idUser']
        ]);

        // On ajoute l'article.
        $articleManager = new ArticleManager();
        $articleManager->addOrUpdateArticle($article);

        // On redirige vers la page d'administration.
        Utils::redirect("admin");
    }


    /**
     * Suppression d'un article.
     * @return void
     */
    public function deleteArticle() : void
    {
        $this->checkIfUserIsConnected();

        $id = Utils::request("id", -1);

        // On supprime l'article.
        $articleManager = new ArticleManager();
        $articleManager->deleteArticle($id);
       
        // On redirige vers la page d'administration.
        Utils::redirect("admin");
    }

    /**
     * Suppression d'un commentaire
     * @return void
     */
    public function deleteComment() : void
    {
        $this->checkIfUserIsConnected();

        $id = Utils::request("id", -1);
        var_dump(intval($id));
        // On supprime le commentaire.
        $commentManager = new CommentManager();
        $commentManager->deleteComment($id);
       
        // On redirige vers la page d'administration.
        Utils::redirect("showMonitoring");
    }

}