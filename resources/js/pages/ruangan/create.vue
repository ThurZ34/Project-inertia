<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import FormRuangan from '@/components/FormRuangan.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

interface Props {
  id: number;
  nama_ruangan: string;
  kode_ruangan: string;
  created_at: string;
  updated_at: string;
}

const props = defineProps<Props>();

const ruangan = {
    id: props.id,
    nama_ruangan: props.nama_ruangan,
    kode_ruangan: props.kode_ruangan,
    created_at: props.created_at,
    updated_at: props.updated_at,
};

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Ruangan',
        href: '/ruangan',
    },
    {
        title: 'Create ruangan',
        href: `/ruangan/create`,
    },
];
</script>

<template>
    <Head title="Create ruangan" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-6">
            <FormRuangan />
        </div>
    </AppLayout>
</template>
