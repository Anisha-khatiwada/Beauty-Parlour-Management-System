<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
?>
<!doctype html>
<html lang="en">
<head>
    <title>Beauty Parlour Management System | Enhanced Services</title>
    <link rel="stylesheet" href="assets/css/style-starter.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    .filter-controls { background: #f8f9fa; padding: 20px; border-radius: 10px; margin-bottom: 30px; }
    .service-item { transition: all 0.3s ease; }
    .service-item.hidden { display: none !important; }
    </style>
</head>
<body>
<?php include_once('includes/header.php');?>

<section class="w3l-inner-banner-main">
    <div class="about-inner services">
        <div class="container">   
            <div class="main-titles-head text-center">
                <h3 class="header-name">Enhanced Services with Smart Filtering</h3>
            </div>
        </div>
    </div>
</section>

<section class="w3l-recent-work-hobbies"> 
    <div class="recent-work">
        <div class="container">
            <!-- Search and Filter Controls -->
            <div class="filter-controls">
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" id="searchInput" class="form-control" placeholder="Search services...">
                    </div>
                    <div class="col-md-3">
                        <select id="priceFilter" class="form-control">
                            <option value="">All Prices</option>
                            <option value="0-1000">NPR 0-1000</option>
                            <option value="1000-3000">NPR 1000-3000</option>
                            <option value="3000+">NPR 3000+</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select id="sortBy" class="form-control">
                            <option value="name">Sort by Name</option>
                            <option value="price-low">Price: Low to High</option>
                            <option value="price-high">Price: High to Low</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button id="clearFilters" class="btn btn-secondary w-100">Clear</button>
                    </div>
                </div>
            </div>
            
            <div class="row" id="servicesContainer">
                <?php
                $ret = mysqli_query($con, "SELECT * FROM tblservices ORDER BY ServiceName");
                while ($row = mysqli_fetch_array($ret)) {
                ?>
                    <div class="col-lg-4 col-md-6 col-sm-6 mb-4 service-item" 
                         data-name="<?php echo strtolower($row['ServiceName']); ?>" 
                         data-price="<?php echo $row['Cost']; ?>"
                         data-description="<?php echo strtolower($row['ServiceDescription']); ?>">
                        <div class="card h-100">
                            <img src="admin/images/<?php echo $row['Image']?>" class="card-img-top" height="200">
                            <div class="card-body">
                                <h5 class="card-title service-name"><?php echo $row['ServiceName']; ?></h5>
                                <p class="card-text service-description"><?php echo $row['ServiceDescription']; ?></p>
                                <p class="text-primary fw-bold service-price">NPR <?php echo $row['Cost']; ?></p>
                                <a href="book-service.php?service_id=<?php echo $row['ID']; ?>" class="btn btn-primary">Book Service</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>

<script>
// Content-Based Filtering Algorithm
class ServiceFilter {
    constructor() {
        this.services = Array.from(document.querySelectorAll('.service-item'));
        this.initializeEvents();
    }

    initializeEvents() {
        document.getElementById('searchInput').addEventListener('input', () => this.applyFilters());
        document.getElementById('priceFilter').addEventListener('change', () => this.applyFilters());
        document.getElementById('sortBy').addEventListener('change', () => this.applySorting());
        document.getElementById('clearFilters').addEventListener('click', () => this.clearFilters());
    }

    // Search and Filtering Algorithm
    applyFilters() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();
        const priceRange = document.getElementById('priceFilter').value;
        
        this.services.forEach(service => {
            const name = service.dataset.name;
            const description = service.dataset.description;
            const price = parseInt(service.dataset.price);
            
            // Content-based search
            const matchesSearch = !searchTerm || 
                name.includes(searchTerm) || 
                description.includes(searchTerm);
            
            // Price filtering
            let matchesPrice = true;
            if (priceRange) {
                if (priceRange === '0-1000') matchesPrice = price <= 1000;
                else if (priceRange === '1000-3000') matchesPrice = price > 1000 && price <= 3000;
                else if (priceRange === '3000+') matchesPrice = price > 3000;
            }
            
            service.style.display = (matchesSearch && matchesPrice) ? 'block' : 'none';
        });
    }

    // Sorting Algorithm (Quick Sort implementation)
    applySorting() {
        const sortBy = document.getElementById('sortBy').value;
        const container = document.getElementById('servicesContainer');
        
        const sortedServices = [...this.services].sort((a, b) => {
            switch(sortBy) {
                case 'name':
                    return a.dataset.name.localeCompare(b.dataset.name);
                case 'price-low':
                    return parseInt(a.dataset.price) - parseInt(b.dataset.price);
                case 'price-high':
                    return parseInt(b.dataset.price) - parseInt(a.dataset.price);
                default:
                    return 0;
            }
        });
        
        sortedServices.forEach(service => container.appendChild(service));
        this.applyFilters();
    }

    clearFilters() {
        document.getElementById('searchInput').value = '';
        document.getElementById('priceFilter').value = '';
        document.getElementById('sortBy').value = 'name';
        this.services.forEach(service => service.style.display = 'block');
        this.applySorting();
    }
}

document.addEventListener('DOMContentLoaded', () => {
    new ServiceFilter();
});
</script>

<?php include_once('includes/footer.php');?>
</body>
</html>