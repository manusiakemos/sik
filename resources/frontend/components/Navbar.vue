<template>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <a class="navbar-brand text-dark text-uppercase" href="#">
            <img loading="lazy" src="images/jdih.png" width="60" height="60" class="d-inline-block align-middle" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault"
                aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
            <ul class="navbar-nav mr-auto text-dark text-uppercase">
                <li class="nav-item">
                    <router-link class="nav-link" to="/">Home <span class="sr-only"></span></router-link>
                </li>
                <li class="nav-item">
                    <router-link class="nav-link" to="/produk-hukum">Produk Hukum</router-link>
                </li>
                <li class="nav-item">
                    <router-link class="nav-link" to="/berita">Berita</router-link>
                </li>
                <li class="nav-item">
                    <a class="nav-link" target="_blank" href="/admin">Login <span class="sr-only"></span></a>
                </li>
               <!-- <li class="nav-item">
                    <router-link class="nav-link" to="galeri">Galeri</router-link>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">Dropdown</a>
                    <div class="dropdown-menu" aria-labelledby="dropdown01">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </li>-->
            </ul>
        </div>

        <a class="navbar-brand text-dark d-none d-md-inline-block" href="#">
            <img loading="lazy" src="/images/tabalong.png" width="50" height="60" class="d-inline-block align-middle" alt="">
        </a>
    </nav>
</template>