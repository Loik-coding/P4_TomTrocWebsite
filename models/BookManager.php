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

    public function getBookById(int $id): ?Book
    {
        //on prépare la requete SQL
        $sql = "SELECT * FROM books WHERE id = :id";
        $query = $this->db->prepare($sql);

        //on associe la valeur de $id au paramètre :id
        $query->execute([
            'id' => $id
        ]);

        //on récupère le résultat
        $bookData = $query->fetch();
        if (!$bookData) {
            return null;
        }
        return new Book($bookData);

    }
}