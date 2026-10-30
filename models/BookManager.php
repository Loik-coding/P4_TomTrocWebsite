<?php

class BookManager extends AbstractEntityManager
{
    public function getAllBooksAvailable(): array
    {
        // On prépare la requête SQL.
        $sql = "SELECT * FROM books WHERE availability = TRUE";

        // On exécute la requête.
        $result = $this->db->query($sql);

        // On initialise un tableau qui contiendra les livres.
        $books = [];

        // On parcourt les résultats.
        while ($bookData = $result->fetch()) {

            // On transforme chaque tableau en objet Book.
            $books[] = new Book($bookData);
        }

        return $books;
    }
}