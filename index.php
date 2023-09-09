<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Latihan CRUD PHP dan Mysql">
    <meta name="keywords" content="HTML, CSS, JavaScript, Latihan HTML, CSS dan Javascript, MSIB5, Kampus Merdeka, Gits.id, Aziz Arif Rizaldi, Belajar HTML, Bejalar CSS, Belajar Javascript, PHP, Mysql, Database">
    <meta name="author" content="Aziz Arif Rizaldi">
    <title>Sistem Peminjaman Buku - Oleh Aziz Arif Rizaldi</title>

    <!-- Bootstrap CSS via External Folder -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="icon" href="images/kampus-merdeka-logo.png" type="image/x-icon">
    <link rel="stylesheet" href="css/style.css?version=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <header class="header">
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <h1 class="navbar-brand text-white">Sistem Peminjaman Buku</h1>
            </div>
        </nav>
    </header>

    <div class="container mt-4">
        <div class="row justify-content-center main-content">
            <div class="col-lg-8 col-sm-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mt-2"><i class="fas fa-filter fa-sm float-end mt-1"></i> Cari buku</h5>
                    </div>
                    <form id="form-perhitungan">
                        <div class="card-body row mt-2">
                            <div class="col-lg-6 mb-2">
                                <input type="text" class="form-control" placeholder="Masukan kata kunci..." name="title_keywords" id="title_keywords">
                            </div>
                            <div class="col-lg-3 mb-2 remove-pl">
                                <button class="btn btn-primary btn-block w-100" type="button" id="btn-search" onclick="load_books()">
                                    <i class="fas fa-search fa-sm"></i> Cari buku
                                </button>
                            </div>
                            <div class="col-lg-3 mb-0 remove-pl">
                                <button class="btn btn-outline-primary btn-block w-100" type="button" id="btn-tambah" data-bs-toggle="modal" data-bs-target="#modal-form-book" onclick="resetID()">
                                    <i class="fas fa-plus fa-sm"></i> Tambah buku
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-8 col-sm-12 col-md-12" style="margin-top:-30px">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mt-2"><i class="fas fa-list fa-sm float-end mt-1"></i> Daftar buku</h5>
                    </div>
                    <div class="card-body text-center" id="loading-content">
                        <h6>Loading... <i class="fa fa-spin fa-spinner fa-sm"></i> </h6>
                    </div>

                    <div id="main-content" class="d-none">
                        <div class="card-body text-center" id="empty-state">
                            <img src="images/empty-box.svg" alt="empty-logo" class="empty-logo">
                            <h6>Buku tidak tersedia.</h6>
                        </div>

                        <div class="card-body table-responsive" id="table-score">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Judul Buku</th>
                                        <th>Pengarang (Author)</th>
                                        <th>Tanggal dibuat</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="body-book">                                
                                </tbody>
                            </table>
                        </div>                    
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <footer class="footer bg-light border-top">
        <div class="footer">
            <p class="text-white text-center pl-5 pr-5 mt-3">© 2023 <a href="https://github.com/azizarizaldi/" target="_blank" class="text-white text-decoration-none">Aziz Arif Rizaldi</a> - Latihan CRUD PHP dan MYSQL. All rights reserved.</p>
        </div>
    </footer>

    <!-- Modal for adding a book -->
    <div class="modal fade mt-5" id="modal-form-book" tabindex="-1" aria-labelledby="modal-form-bookLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-form-label">Tambah Buku</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btn-close-modal"></button>
                </div>
                <form id="form-buku">
                    <div class="modal-body">
                    <input type="hidden" class="form-control" id="book-id" name="book-id">
                        <div class="mb-3">
                            <label for="book-title" class="form-label">Judul Buku <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="book-title" name="book-title" required oninvalid="this.setCustomValidity('Masukan judul buku')" oninput="this.setCustomValidity('')">
                        </div>
                        <div class="mb-3">
                            <label for="author" class="form-label">Pengarang (Author) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="author" name="author" required oninvalid="this.setCustomValidity('Masukan nama pengarang')" oninput="this.setCustomValidity('')">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save fa-sm"></i> Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="js/bootstrap.min.js"></script>
    <script>
        document.getElementById("form-buku").addEventListener("submit", function (event) {
            event.preventDefault();
            
            const id = document.getElementById("book-id").value;
            const book_title = document.getElementById("book-title").value;
            const author     = document.getElementById("author").value;

            const formData = new FormData();
            formData.append("id", id);
            formData.append("book-title", book_title);
            formData.append("author", author);

            fetch("helper/action.php", {
                method: "POST",
                body: formData,
            })
            .then(response => response.json())
            .then(data => {                
                if (data.status) {
                    load_books();
                }

                alert(data.message)
            })
            .catch(error => {
                console.error("Error:", error);
                alert("Terjadi kesalahan saat mengirimkan request.");
            });

            modal_clear();
        });

        const searchInput = document.getElementById("title_keywords");
        searchInput.addEventListener("keydown", function(event) {
            if (event.key === "Enter") {
                event.preventDefault(); // Mencegah tindakan default (form submit)
                load_books();
            }
        });

        load_books();
        function load_books() {
            const loading = document.getElementById("loading-content");
            loading.classList.remove("d-none");

            const main_content = document.getElementById("main-content");
            main_content.classList.add("d-none");

            const searchInput = document.getElementById("title_keywords");
            const keywords = searchInput.value; // Ambil nilai dari input pencarian

            fetch(`helper/load.php?keywords=${encodeURIComponent(keywords)}`, {
                method: "GET",
            })
            .then(response => response.json())
            .then(data => {
                loading.classList.add("d-none");
                main_content.classList.remove("d-none");

                const tbody = document.getElementById("body-book");
                tbody.innerHTML = "";
                data.books_data.forEach((book, index) => {
                    const row = `
                        <tr>
                            <td class="text-center">${index + 1}</td>
                            <td>${book.title}</td>
                            <td>${book.author}</td>
                            <td>${book.created_at}</td>
                            <td class="text-center">
                                <button class="btn btn-primary btn-sm mb-1" onclick="editBook(${book.id}, '${book.title}', '${book.author}')">
                                    <i class="fas fa-edit"></i> Ubah
                                </button>
                                <button class="btn btn-danger btn-sm mb-1" onclick="deleteBook(${book.id})">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </td>
                        </tr>
                    `;
                    tbody.innerHTML += row;
                });

                // Tampilkan atau sembunyikan pesan jika tabel kosong
                const emptyState = document.getElementById("empty-state");
                const tableScore = document.getElementById("table-score");

                if (data.books_data.length === 0) {
                    emptyState.classList.remove("d-none");
                    tableScore.classList.add("d-none");
                } else {
                    emptyState.classList.add("d-none");
                    tableScore.classList.remove("d-none");
                }
            })
            .catch(error => {
                console.error("Error:", error);
                alert("Terjadi kesalahan saat mengambil data buku.");
            });
        }

        function modal_clear() {
            document.getElementById("btn-close-modal").click();
            document.getElementById("book-title").value = '';
            document.getElementById("author").value = '';
        }

        function deleteBook(id) {
            if (confirm("Apakah Anda yakin ingin menghapus buku ini?")) {
                fetch(`helper/delete.php?id=${id}`, {
                    method: "DELETE",
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status) {
                        load_books();
                    }
                    alert(data.message);
                })
                .catch(error => {
                    console.error("Error:", error);
                    alert("Terjadi kesalahan saat mengirimkan permintaan penghapusan.");
                });
            }
        }

        function resetID() {
            document.getElementById("modal-form-label").text = "Tambah Buku";
            document.getElementById("book-id").value = "";
        }

        function editBook(id, title, author) {
            document.getElementById("modal-form-label").text = "Ubah Buku";
            document.getElementById("book-id").value = id;
            document.getElementById("book-title").value = title;
            document.getElementById("author").value = author;
            const bookModal = new bootstrap.Modal(document.getElementById("modal-form-book"));
            bookModal.show();
        }        
    </script>

</body>
</html>
