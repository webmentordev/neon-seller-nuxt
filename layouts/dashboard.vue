<template>
    <NuxtLoadingIndicator />
    <div class="flex h-screen overflow-y-scroll">
        <div class="max-w-[200px] w-full">
            <DashboardNavbar />
        </div>
        <div class="w-full bg-primary-gray p-6">
            <slot />
        </div>
    </div>
</template>