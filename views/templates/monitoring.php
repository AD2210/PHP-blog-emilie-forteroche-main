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
                    <div>
                        <a href="index.php?action=showMonitoring&order=title&direction=ASC">↑</a>
                        <a href="index.php?action=showMonitoring&order=title&direction=DESC">↓</a>
                    </div>
                </div>
            </th>
            <th scope="col">
                <div class="headLine">
                    <div>Publié le</div>
                    <div>
                        <a href="index.php?action=showMonitoring&order=date_creation&direction=ASC">↑</a>
                        <a href="index.php?action=showMonitoring&order=date_creation&direction=DESC">↓</a>
                    </div>
                </div>
            </th>
            <th scope="col">
                <div class="headLine">
                    <div>Vues</div>
                    <div>
                        <a href="index.php?action=showMonitoring&order=nb_vue&direction=ASC">↑</a>
                        <a href="index.php?action=showMonitoring&order=nb_vue&direction=DESC">↓</a>
                    </div>
                </div>
            </th>
            <th scope="col">
                <div class="headLine">
                    <div>Commentaires</div>
                    <div>
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
            ?>
            <tr class="tableLine <?php echo ($i % 2 == 0) ? 'lignePaire' : 'ligneImpaire'; ?>">
                <th scope="row" class="title"><?= $data['title'] ?></th>
                <td><?= Utils::convertDateToFrenchFormat($data['date_creation']) ?></td>
                <td><?= $data['nb_vue'] ?></td>
                <td>
                    <div class="com">
                        <?= $data['nb_comment'] ?>
                        <a class="submit" href="index.php?action=commentManagement&id=<?php echo ($data['id']) ?>">Gerer</a>
                    </div>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<div class="navAdmin">
    <a class="submit" href="index.php?action=admin">Gestion des articles</a>
</div>