<script setup lang="ts">
import { route } from 'ziggy-js';
import Swal from 'sweetalert2';
import { router } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Link, Head, usePage } from '@inertiajs/vue3';
import { Pencil, Trash  } from 'lucide-vue-next';

interface ruangan {
  id: number;
  nama_ruangan: string;
  kode_ruangan: string;
  created_at: string;
  updated_at: string;
}

const { props } = usePage();
const ruanganList = props.ruangan as ruangan[];

const createRoute = () => route('ruangan.create');
const editruangan = (id: number) => route('ruangan.edit', { id });

const getThemedSwalOptions = () => {
  const isDarkMode = document.documentElement.classList.contains('dark');
  return {
    background: isDarkMode ? '#1f2937' : '#ffffff',
    color: isDarkMode ? '#ffffff' : '#000000',
    confirmButtonColor: '#3b82f6',
    cancelButtonColor: '#d33',
  };
};

const deleteruangan = (id: number) => {
  Swal.fire({
    title: 'Apakah Anda yakin?',
    text: "Data ruangan ini akan dihapus permanen!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Ya, hapus!',
    cancelButtonText: 'Batal',
    ...getThemedSwalOptions()
  }).then((result) => {
    if (result.isConfirmed) {
      router.delete(route('ruangan.destroy', id, undefined, (props as any).ziggy), {
        preserveState: false,
        onSuccess: () => {
          Swal.fire({
            title: 'Terhapus!',
            text: 'Data ruangan berhasil dihapus.',
            icon: 'success',
            ...getThemedSwalOptions()
          });
        },
        onError: (errors) => {
          Swal.fire({
            title: 'Error!',
            text: 'Terjadi kesalahan saat menghapus data.',
            icon: 'error',
            ...getThemedSwalOptions()
          });
          console.error('Error deleting ruangan:', errors);
        }
      });
    }
  });
};

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Ruangan',
        href: "/ruangan",
    },

];
</script>

<template>
    <Head title="Ruangan" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4">
            <div class="mb-4">
                <Link :href="createRoute()">
                    <Button variant="outline"> Tambah ruangan Baru </Button>
                </Link>
            </div>

            <div class="bg-white dark:bg-input/30 shadow-md rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
                    <thead class="bg-neutral-50 dark:bg-input/30">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-100 uppercase tracking-wider">
                                Nama Ruangan
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-100 uppercase tracking-wider">
                                Kode Ruangan
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-100 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-input/30 divide-y divide-neutral-200 dark:divide-neutral-700">
                        <tr v-for="ruangan in ruanganList" :key="ruangan.id" class="hover:bg-neutral-50 dark:hover:bg-neutral-700">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-neutral-900 dark:text-neutral-100">{{ ruangan.nama_ruangan }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-neutral-900 dark:text-neutral-100">{{ ruangan.kode_ruangan }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center justify-start">
                                    <Link
                                        :href="editruangan(ruangan.id)"
                                        class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300 mr-3"
                                    >
                                        <Pencil />
                                    </Link>
                                    <button
                                        @click="deleteruangan(ruangan.id)"
                                        class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300"
                                        type="button"
                                    >
                                        <Trash />
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div v-if="ruanganList && ruanganList.length === 0" class="text-center py-8">
                    <p class="text-neutral-500 dark:text-neutral-400">Tidak ada data ruangan ditemukan.</p>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

