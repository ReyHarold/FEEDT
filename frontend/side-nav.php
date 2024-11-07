<style>
    aside {
    background-color: #f4f4f4;
    width: 200px;
    height: 100vh;
    position: fixed;
    top: 72px;
    left: 0;
    overflow-y: auto;
    border-right: 2px solid #000;
}

aside ul {
    list-style-type: none;
    padding: 0;
    margin: 0;
}



aside a {
    display: flex;
    align-items: center;
    padding: 15px;
    color: #333;
    text-decoration: none;
    transition: background-color 0.3s;
}

aside a:hover {
    background-color: #ddd;
}

aside a.active {
    background-color: #75e077;
    border-top: 2px solid #000;
    border-bottom: 2px solid #000;
    /* Removed border */
}

aside a.active:hover {
    background-color: #45a049;
}

aside img {
    width: 24px;
    height: 24px;
    margin-right: 10px;
    padding: 2px;
}
</style>
<aside>
    <ul>
        <li><a href="#" class="active"><img src="icons/home.png" alt="Home">Home</a></li>
        <li><a href="#"><img src="icons/users.png" alt="Users">Users</a></li>
        <li><a href="#"><img src="icons/inve.png" alt="Inventory">Inventory</a></li>
        <li><a href="#"><img src="icons/orders.png" alt="Orders">Orders</a></li>
        <li><a href="#"><img src="icons/suppliers.png" alt="Suppliers">Suppliers</a></li>
        <li><a href="#"><img src="icons/report.png" alt="Reports">Reports & Analytics</a></li>
    </ul>
</aside>

