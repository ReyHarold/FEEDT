<!-- Dashboard Content -->
<div class="dashboard">
    <!-- Inventory Chart -->
    <a onclick="loadContent('report2', this)">
        <div class="card card-inventory">
            <canvas id="inventoryChart"></canvas>
        </div>
    </a>
    <!-- Production Chart -->
    <a onclick="loadContent('report3', this)">
        <div class="card card-production">
            <canvas id="productionChart"></canvas>
        </div>
    </a>
    <!-- Sales Chart -->
    <a onclick="loadContent('report4', this)">
        <div class="card card-sales">
            <canvas id="salesChart"></canvas>
        </div>
    </a>
</div>
<style>
    /* Dashboard grid layout */
.dashboard {
    width: 100%;
    display: grid;
    grid-template-columns: repeat(1, 1fr);
    grid-gap: 20px;
    margin: 20px;
}

@media (min-width: 768px) {
    .dashboard {
        grid-template-columns: repeat(2, 1fr);
    }
}

/* Card styling */
.card {
    background-color: white;
    padding: 20px;
    border: 2px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    text-align: center;
    display: flex;
    justify-content: center;
    align-items: center;
    position: relative;
}

.card-inventory {
    background-color: #f2f2f2;
}

.card-production {
    background-color: #e8f4fc;
}

.card-sales {
    background-color: #fff8e1;
}

/* Hover effect */
.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
    transition: 0.3s;
}

.card canvas {
    max-width: 100%;
    height: auto;
}

</style>