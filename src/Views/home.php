<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Futebol Matches</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        #loading {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.7);
            z-index: 9999;
        }
        #loading img {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    </style>
</head>
<body>
<div id="loading">
    <img src="https://i.gifer.com/YCZH.gif" alt="Loading...">
</div>
<div class="container mt-5">
    <h1>Buscar por Time</h1>
    <form method="get" action="">
        <div class="d-flex flex-row">
            <div class="mb-3 w-50">
                <input type="text" class="form-control" style="height: 40px;" name="team" placeholder="Digite o nome do time">
            </div>
            <button type="submit" name="action" value="search" class="btn btn-primary ms-2" style="height: 40px;">Buscar</button>
        </div>
    </form>
    <?php if (isset($_GET['action']) && $_GET['action'] === 'search' && (isset($_GET['team']) && !empty($_GET['team']))) : ?>
        <a href="index.php">Limpar filtro</a>
        <h1 class="mb-4"><?php echo $_GET['team']; ?> Campeonato Brasileiro 2023</h1>
    <?php else : ?>
        <h1 class="mb-4">Tabela Campeonato Brasileiro 2023</h1>
    <?php endif; ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Casa</th>
                <th scope="col">Visitante</th>
                    <th scope="col">Placar</th>
                <th scope="col">Data/Hora</th>
                <th scope="col">Estádio</th>
            </tr>
        </thead>
        <tbody id="match-table-body"></tbody>
    </table>
    <nav>
        <div class="d-flex justify-content-between align-items-center">
            <ul class="pagination" id="pagination"></ul>
            <div class="d-flex align-items-center"> 
                <label for="resultsPerPage" class="me-2">Resultados por página:</label>
                <select class="form-select" id="resultsPerPage" onchange="changeResultsPerPage(this.value)">
                    <option value="5">5</option>
                    <option value="10" selected>10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                    <option value="all">Tudo</option>
                </select>
            </div>
        </div>
    </nav>
</div>
<footer class="mt-5">
    <div class="container text-center">
        <p>Desenvolvido por <a href="https://github.com/cesarfarkas" target="_blank">GitHub: César Farkas</a></p>
        <p>Usa a API <a href="https://www.api-football.com/" target="_blank">API-Football</a>. Neste projeto foi usada a versão free, por isso apenas existe o Campeonato Brasileiro de 2023.</p>
    </div>
</footer>
<script>
    const matches = <?php echo json_encode($matches); ?>;
    const matchTableBody = document.getElementById('match-table-body');
    const pagination = document.getElementById('pagination');
    let resultsPerPage = 10;
    let currentPage = 1;

    function showLoading() {
        document.getElementById('loading').style.display = 'block';
    }

    function hideLoading() {
        document.getElementById('loading').style.display = 'none';
    }

    function renderMatches() {
        matchTableBody.innerHTML = '';
        const startIndex = (currentPage - 1) * resultsPerPage; // Usar resultsPerPage aqui
        let endIndex = startIndex + resultsPerPage;
        if (endIndex > matches.length) {
            endIndex = matches.length;
        }
        const currentMatches = matches.slice(startIndex, endIndex);
        
        currentMatches ? (
            currentMatches.forEach(match => {
                const row = `<tr>
                    <td><img src="${match.teams.home.logo}" alt="${match.teams.home.name}" height="20" /> ${match.teams.home.name}</td>
                    <td><img src="${match.teams.away.logo}" alt="${match.teams.away.name}" height="20" /> ${match.teams.away.name}</td>
                    <td scope="col">${match.goals && match.goals.home !== null && match.goals.away !== null ? `${match.goals.home} x ${match.goals.away}` : 'não jogaram'}</td>
                    <td>${new Date(match.fixture.date).toLocaleDateString('pt-BR', {year: 'numeric', month: 'numeric', day: 'numeric', hour: 'numeric', minute: 'numeric'})}</td>
                    <td>${match.fixture.venue?.name.replace('Estádio ', '') || 'N/A'}</td>
                </tr>`;
                matchTableBody.innerHTML += row;
            })
        ) : (
            matchTableBody.innerHTML = '<tr><td colspan="4">Nenhum resultado encontrado.</td></tr>'
        );
    }

    function renderPagination() {
        pagination.innerHTML = '';
        const totalPages = Math.ceil(matches.length / resultsPerPage); // Usar resultsPerPage aqui

        if (totalPages <= 7) {
            for (let i = 1; i <= totalPages; i++) {
                createPageItem(i);
            }
        } else {
            if (currentPage <= 4) {
                for (let i = 1; i <= 5; i++) {
                    createPageItem(i);
                }
                createEllipsis();
                createPageItem(totalPages);
            } else if (currentPage >= totalPages - 3) {
                createPageItem(1);
                createEllipsis();
                for (let i = totalPages - 4; i <= totalPages; i++) {
                    createPageItem(i);
                }
            } else {
                createPageItem(1);
                createEllipsis();
                for (let i = currentPage - 2; i <= currentPage + 2; i++) {
                    createPageItem(i);
                }
                createEllipsis();
                createPageItem(totalPages);
            }
        }
    }

    function createPageItem(i) {
        const pageItem = document.createElement('li');
        pageItem.className = `page-item ${i === currentPage ? 'active' : ''}`;
        pageItem.innerHTML = `<a class="page-link ${i === currentPage ? 'disabled' : ''}" href="#">${i}</a>`;

        if (i !== currentPage) {
            pageItem.addEventListener('click', (e) => {
                e.preventDefault();
                currentPage = i;
                renderMatches();
                renderPagination();
            });
        }

        pagination.appendChild(pageItem);
    }

    function createEllipsis() {
        const ellipsis = document.createElement('li');
        ellipsis.className = 'page-item disabled';
        ellipsis.innerHTML = '<span class="page-link">...</span>';
        pagination.appendChild(ellipsis);
    }

    function changeResultsPerPage(value) {
        if (value === 'all') {
            resultsPerPage = matches.length;
        } else {
            resultsPerPage = parseInt(value);
        }
        currentPage = 1; // Resetar a página para 1
        renderMatches();
        renderPagination();
    }

    document.addEventListener("DOMContentLoaded", function () {
        showLoading();
        setTimeout(() => {
            renderMatches();
            renderPagination();
            hideLoading();
        }, 500);
    });

    // Tornar a função changeResultsPerPage acessível globalmente
    window.changeResultsPerPage = changeResultsPerPage;
</script>
</body>
</html>