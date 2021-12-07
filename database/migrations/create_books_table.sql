CREATE TABLE IF NOT EXISTS books (
    id INTEGER UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title TEXT NOT NULL,
    isbn TEXT,
    pageCount INTEGER,
    thumbnailUrl TEXT,
    shortDescription LONGTEXT,
    longDescription LONGTEXT,
    status TEXT NOT NULL
);