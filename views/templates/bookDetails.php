<!DOCTYPE html>

<h1><?=htmlspecialchars($book->getTitle())?></h1>
<h2><?=htmlspecialchars($book->getAuthor())?></h2>
<p><?=htmlspecialchars($book->getDescription())?></p>
<p>vendu par :<?=htmlspecialchars($book->getUserId())?></p>