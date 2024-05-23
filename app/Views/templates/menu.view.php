<!-- 
Esta página contiene el menu principal del sitio, situado en el header
-->

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading text-success">
    Personal
</div>
<?php
if (strpos($_SESSION['permisos'], 'w') !== false) {
    ?>
    <!-- Nav Item - Collapse Menu -- Usuarios -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUsers"
           aria-expanded="true" aria-controls="collapseUsers">
            <i class="fas fa-fw fa-users"></i>
            <span>Usuarios</span>
        </a>
        <div id="collapseUsers" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="/usuarios">Ver usuarios</a>
                <a class="collapse-item" href="/usuario/add">Añadir usuario</a>
            </div>
        </div>
    </li>
    <?php
} else {
    ?>
    <li class="nav-item">
        <a class="nav-link" href="/usuarios">
            <i class="fas fa-fw fa-users"></i>
            <span>Usuarios</span></a>
    </li>
    <?php
}
?>

<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading text-success">
    Inventario
</div>

<?php
if (strpos($_SESSION['permisos'], 'w') !== false) {
    ?>
    <!-- Nav Item - Collapse Menu Familia -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFamilies"
           aria-expanded="true" aria-controls="collapseFamilies">
            <i class="fas fa-fw fa-th"></i>
            <span>Familias</span>
        </a>
        <div id="collapseFamilies" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="/familias">Ver familias</a>
                <a class="collapse-item" href="/familia/add">Añadir Familia</a>
            </div>
        </div>
    </li>
    <?php
} else {
    ?>
    <li class="nav-item">
        <a class="nav-link" href="/familias">
            <i class="fas fa-fw fa-th"></i>
            <span>Familias</span></a>
    </li>
    <?php
}
?>

<?php
if (strpos($_SESSION['permisos'], 'w') !== false) {
    ?>
    <!-- Nav Item - Collapse Menu Categoría -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCategories"
           aria-expanded="true" aria-controls="collapseCategories">
            <i class="fas fa-fw fa-th-large"></i>
            <span>Categorías</span>
        </a>
        <div id="collapseCategories" class="collapse" aria-labelledby="headingUtilities"
             data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="/categorias">Ver categorías</a>
                <a class="collapse-item" href="/categoria/add">Añadir categoría</a>
            </div>
        </div>
    </li>
    <?php
} else {
    ?>
    <li class="nav-item">
        <a class="nav-link" href="/categorias">
            <i class="fas fa-fw fa-th-large"></i>
            <span>Categorias</span></a>
    </li>
    <?php
}
?>

<?php
if (strpos($_SESSION['permisos'], 'w') !== false) {
    ?>
    <!-- Nav Item - Collapse Menu -- Piezas -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePieces"
           aria-expanded="true" aria-controls="collapsePieces">
            <i class="fas fa-fw fa-cog"></i>
            <span>Piezas</span>
        </a>
        <div id="collapsePieces" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="/piezas">Ver Piezas</a>
                <a class="collapse-item" href="/pieza/add">Añadir Pieza</a>
            </div>
        </div>
    </li>
    <?php
} else {
    ?>
    <li class="nav-item">
        <a class="nav-link" href="/piezas">
            <i class="fas fa-fw fa-cog"></i>
            <span>Piezas</span></a>
    </li>
    <?php
}
?>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading text-success">
    Organización
</div>

<?php
if (strpos($_SESSION['permisos'], 'w') !== false) {
    ?>
    <!-- Nav Item - Collapse Menu -- Eventos -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseEvents"
           aria-expanded="true" aria-controls="collapseEvents">
            <i class="fas fa-fw fa-calendar"></i>
            <span>Eventos</span>
        </a>
        <div id="collapseEvents" class="collapse" aria-labelledby="headingUtilities"
             data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="">Ver eventos</a>
                <a class="collapse-item" href="">Añadir evento</a>
            </div>
        </div>
    </li>
    <?php
} else {
    ?>
    <li class="nav-item">
        <a class="nav-link" href="/">
            <i class="fas fa-fw fa-calendar"></i>
            <span>Eventos</span></a>
    </li>
    <?php
}
?>

<?php
if (strpos($_SESSION['permisos'], 'w') !== false) {
    ?>
    <!-- Nav Item - Collapse Menu -- Clientes -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseClients"
           aria-expanded="true" aria-controls="collapseClients">
            <i class="fas fa-fw fa-user"></i>
            <span>Clientes</span>
        </a>
        <div id="collapseClients" class="collapse" aria-labelledby="headingUtilities"
             data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="">Ver categorías</a>
                <a class="collapse-item" href="">Añadir categoría</a>
            </div>
        </div>
    </li>
    <?php
} else {
    ?>
    <li class="nav-item">
        <a class="nav-link" href="/">
            <i class="fas fa-fw fa-user"></i>
            <span>Clientes</span></a>
    </li>
    <?php
}
?>

<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block">

<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0 bg-gradient-success" id="sidebarToggle"></button>
</div>

</ul>
<!-- End of Sidebar -->
