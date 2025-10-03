<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import ruanganForm from '@/components/FormRuangan.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

interface Props {
    ruangan: {
        id: number;
        nama: string;
        nisn: string;
        no_telpon: string;
        kelas: string;
    };
}

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'ruangan',
        href: '/ruangan',
    },
    {
        title: 'Edit ruangan',
        href: `/ruangan/${props.ruangan.id}/edit`,
    },
];
</script>

<template>
    <Head title="Edit ruangan" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-6">
            <ruanganForm :ruangan="ruangan" :is-edit="true" />
        </div>
    </AppLayout>
</template>
