<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { useForm } from '@inertiajs/vue3';
import { Save, X } from 'lucide-vue-next';
import { watch } from 'vue';

// 1. Update the Props Interface to match the Ruangan model
interface Props {
    ruangan?: {
        id?: number;
        nama_ruangan: string;
        kode_ruangan: string;
    };
    isEdit?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
    isEdit: false,
    ruangan: () => ({
        nama_ruangan: '',
        kode_ruangan: '',
    }),
});

// 2. Update the form data keys to match the controller's validation
const form = useForm({
    nama_ruangan: '',
    kode_ruangan: '',
});

watch(
    () => props.ruangan,
    (newRuangan) => {
        if (newRuangan) {
            form.nama_ruangan = newRuangan.nama_ruangan;
            form.kode_ruangan = newRuangan.kode_ruangan;
        }
    },
    { deep: true, immediate: true },
);

// 3. Update the submit logic to use the 'ruangan' routes
const submit = () => {
    if (props.isEdit && props.ruangan?.id) {
        // Edit/Update: PUT request to /ruangan/{id}
        form.put(`/ruangan/${props.ruangan.id}`, {
            preserveScroll: true,
            // The controller redirects on success, so no explicit form.reset() is needed,
            // but we can keep it if you want to clear the form on successful Inertia response.
            onSuccess: () => form.reset(),
        });
    } else {
        // Create/Store: POST request to /ruangan
        form.post('/ruangan', {
            preserveScroll: true,
            onSuccess: () => form.reset(),
        });
    }
};
</script>

<template>
    <Card class="max-w-2xl mx-auto">
        <CardHeader>
            <CardTitle>{{ isEdit ? 'Edit Data Ruangan' : 'Tambah Ruangan Baru' }}</CardTitle>
            <CardDescription>
                {{ isEdit ? 'Perbarui informasi ruangan' : 'Masukkan data ruangan yang akan ditambahkan' }}
            </CardDescription>
        </CardHeader>
        <CardContent>
            <form @submit.prevent="submit" class="space-y-6">
                <div class="space-y-2">
                    <Label for="nama_ruangan" class="required">Nama Ruangan</Label>
                    <Input
                        id="nama_ruangan"
                        v-model="form.nama_ruangan"
                        type="text"
                        placeholder="Contoh: Lab RPL, Lab TKJ, dll"
                        :class="{ 'border-red-500': form.errors.nama_ruangan }"
                        required
                    />
                    <p v-if="form.errors.nama_ruangan" class="text-sm text-red-500">
                        {{ form.errors.nama_ruangan }}
                    </p>
                </div>

                <div class="space-y-2">
                    <Label for="kode_ruangan" class="required">Kode Ruangan</Label>
                    <Input
                        id="kode_ruangan"
                        v-model="form.kode_ruangan"
                        type="text"
                        placeholder="Contoh: B1, B2, Dll."
                        :class="{ 'border-red-500': form.errors.kode_ruangan }"
                        required
                    />
                    <p v-if="form.errors.kode_ruangan" class="text-sm text-red-500">
                        {{ form.errors.kode_ruangan }}
                    </p>
                </div>

                <div class="flex gap-3 pt-4">
                    <Button type="submit" :disabled="form.processing" class="flex-1">
                        <Save class="w-4 h-4 mr-2" />
                        {{ form.processing ? 'Menyimpan...' : (isEdit ? 'Perbarui' : 'Simpan') }}
                    </Button>
                    <Button
                        type="button"
                        variant="outline"
                        @click="$inertia.visit('/ruangan')"
                        :disabled="form.processing"
                    >
                        <X class="w-4 h-4 mr-2" />
                        Batal
                    </Button>
                </div>
            </form>
        </CardContent>
    </Card>
</template>

<style scoped>
.required::after {
    content: ' *';
    color: rgb(239 68 68);
}
</style>
