<?php
/** 
 * Affichage de la partie gestion des commentaires : liste des commentaire pour chaque article
 * 
 */
?>

<h2>Commentaires de l'article : <?php echo $article['title'] ?> </h2>

<table class="tableMonitoring">
    <thead>
        <tr class="tableLine">
            <th scope="col">
                <div class="headLine">
                    Pseudo
                </div>
            </th>
            <th scope="col">
                <div class="headLine">
                    Publié le
                </div>
            </th>
            <th scope="col">
                <div class="headLine">
                    Commentaire
                </div>
            </th>
            <th scope="col">
                <div class="headLine">
                    Supprimer
                </div>
            </th>
        </tr>
    </thead>
    <tbody>

        <?php
        //Variable permettant d'avoir le numero de ligne et différencier l'affichage des lignes paire et impaire grace à leur classe respective
        $i = 0;
        foreach ($comments as $comment) {
            $i++;
            $colorLine = ($i % 2 == 0) ? 'lignePaire' : 'ligneImpaire';
            $pseudo = $comment->getPseudo();
            $dateCreation = Utils::convertDateToFrenchFormat($comment->getDateCreation());
            $commentContent = $comment->getContent();
            $id = $comment->getId();
            $confirmation = Utils::askConfirmation("Êtes-vous sûr de vouloir supprimer ce commentaire ?");

            // PHP Heredoc pour afficher les variables récupérés.
            $tableLine = <<<TABLE
                <tr class="tableLine $colorLine">
                    <th scope="row" class="title">$pseudo</th>
                    <td>$dateCreation</td>
                    <td>$commentContent</td>
                    <td>
                        <div>
                            <a class="submit" href="index.php?action=deleteComment&id=$id" $confirmation>Supprimer</a>
                        </div>
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
    <a class="submit" href="index.php?action=showMonitoring">Afficher les statistiques</a>
</div>