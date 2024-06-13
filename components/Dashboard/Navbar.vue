<template>
    <div class="flex flex-col bg-white p-3">
        <nuxt-link to="/" class="border-b border-gray-200 pb-3">
            <img src="/logo.png" alt="Logo" class="max-w-[50%] w-full m-auto">
        </nuxt-link>
        <ul class="font-bold mt-6 dashboard">
            <DashboardLink class="mb-3" to="/dashboard" src="uil:github">Dashboard</DashboardLink>
            <DashboardLink class="mb-3" to="/dashboard/products" src="gridicons:product">Products</DashboardLink>
            <DashboardLink class="mb-3" to="/dashboard/products/categories" src="solar:pin-list-bold-duotone">Categories</DashboardLink>
            <DashboardLink class="mb-3" to="/dashboard/products/create" src="material-symbols-light:create-new-folder">Add Product</DashboardLink>
            <DashboardLink class="mb-3" to="/dashboard/products/prices" src="gravity-ui:circle-dollar">Prices</DashboardLink>
            <DashboardLink class="mb-3" to="/dashboard/contacts" src="ri:contacts-fill">Contacts</DashboardLink>
            <DashboardLink class="mb-3" to="/dashboard/orders" src="ri:shopping-bag-4-fill">Orders</DashboardLink>
            <DashboardLink class="mb-3" to="/dashboard/users" src="material-symbols:person">Users</DashboardLink>
        </ul>
    </div>
</template>