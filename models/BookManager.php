<?php

class BookManager extends AbstractEntityManager
{
//-------------------------------------------------------------------------------//
//    01 - GETTERS                                                               //
//-------------------------------------------------------------------------------//

    // Fonction GetBooks avec paramètres.
    public function getBooksByParameters(string $select, string $join, string $where, string $orderBy, string $quantity)
    {
        // Prépare la requete SQL paramétrée.
        $sql = "SELECT $select FROM books $join WHERE $where $orderBy $quantity";
        $query = $this->db->prepare($sql);

        // On initialise un tableau qui contiendra les livres.
        $books = [];
        // On execute la requête.
        $query->execute();

        // On parcourt les résultats.
        while ($bookData = $query->fetch()) {
            // On transforme chaque tableau en objet Book.
            $books[] = new Book($bookData);
        }
        return $books;
    }

    // Fonction GetBook avec l'id du livre.
    public function getBookById(int $id): ?Book
    {
        // On prépare la requete SQL.
        $sql = "SELECT books.*, users.pseudo, users.profile_picture FROM books INNER JOIN users ON books.user_id = users.id WHERE books.id = :id";
        $query = $this->db->prepare($sql);

        // On associe la valeur de $id au paramètre :id.
        $query->execute(['id' => $id]);

        // On récupère le résultat.
        $bookData = $query->fetch();
        if (!$bookData) {
            return null;
        }
        return new Book($bookData);
    }

    // Fonction getBooks avec l'id du user.
    public function getBooksByUserId(int $id): array
    {
        // On prépare la requete SQL.
        $sql = "SELECT * FROM books WHERE user_id = :id";
        $query = $this->db->prepare($sql);

        // On execute avec l'id de l'utilisateur.
        $query->execute(['id' => $id]);

        // On récupère le résultat.
        $books = [];
        while ($bookData = $query->fetch()) {
            $books[] = new Book($bookData);
        }
        return $books;
    }

    // Fonction pour récupérer le nombre de livre mis en ligne par utilisateur.
    public function getBooksCountByUserId(int $userId): int
    {
        // On prépare la requete SQL.
        $sql = "SELECT COUNT(*) as booksCount FROM books WHERE user_id = :userId";
        $query = $this->db->prepare($sql);

        // On execute avec l'id de l'utilisateur.
        $query->execute([
            'userId' => $userId
        ]);

        // On récupère le résultat.
        $result = $query->fetch();
        return $result['booksCount'] ?? 0;
    }

    // Fonction de recherche de livre avec correspondance partielle du titre ou auteur.
    public function searchBooks(string $search): array
    {
        // On prépare la requete SQL.
        $sql = "SELECT * FROM books WHERE availability = TRUE AND (title LIKE :search OR author LIKE :search)";
        $query= $this->db->prepare($sql);

        // On execute avec la recherche effectuée.
        $query->execute([
            'search' => '%' . $search . '%'
        ]);

        // On récupère le résultat.
        $books = [];
        while ($bookData = $query->fetch()) {
            $books[] = new Book($bookData);
        }
        return $books;
    }

//-------------------------------------------------------------------------------//
//    02 - AJOUTS ET SUPPRESSIONS                                                //
//-------------------------------------------------------------------------------//
    
    // Fonction de création de livre
    public function createBook(string $title, string $author, string $description, bool $availability, string $cover, int $userId): bool
    {
        // On prépare la requete SQL.
        $sql = "INSERT INTO books (title, author, description, availability, cover, user_id) 
            VALUES (:title, :author, :description, :availability, :cover, :user_id)";
        $query= $this->db->prepare($sql);

        // On execute avec les paramètres d'entrée.
        return $query->execute([
            'title' => $title,
            'author' => $author,
            'description' => $description,
            'availability' => $availability,
            'cover' => $cover,
            'user_id' => $userId,
            ]);
    }

    // Fonction de suppression de livre
    public function deleteBookById(int $id): bool
    {
        // On prépare la requete SQL.
        $sql = "DELETE FROM books WHERE id = :id";
        $query= $this->db->prepare($sql);
        
        // On execute avec l'id du livre = suppression.
        return $query->execute(['id' => $id]);
    }

//-------------------------------------------------------------------------------//
//    03 - MODIFICATIONS                                                         //
//-------------------------------------------------------------------------------//

    //Fonction de modification de la cover.
    public function updateBookCover(int $bookId, string $coverPath): bool
    {
        // On prépare la requete SQL.
        $sql = "UPDATE books SET cover = :cover WHERE id = :id";
        $query = $this->db->prepare($sql);

        // On execute avec le nouveau lien de l'image et l'id du livre concerné.
        return $query-> execute([
            'cover' => $coverPath,
            'id' => $bookId
        ]);
    }

    //Fonction de modification des informations du livre hors cover.
    public function updateBook(int $bookId, string $title, string $author, string $description, bool $availability): bool
    {
        // On prépare la requete SQL.
        $sql = "UPDATE books SET title = :title, author = :author, description = :description, availability = :availability WHERE id = :id";
        $query = $this->db->prepare($sql);

        // On execute avec tous les paramètres d'entrée.
        return $query-> execute([
            'title' => $title,
            'author' => $author,
            'description' => $description,
            'availability' => $availability,
            'id' => $bookId
        ]);
    }
}