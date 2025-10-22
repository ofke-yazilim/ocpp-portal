import AppLayout from '@/layouts/app-layout';
import { Head, useForm } from '@inertiajs/react';
import { type BreadcrumbItem } from '@/types';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Textarea } from '@/components/ui/textarea';
import {Label} from "@/components/ui/label";
import InputError from "@/components/input-error";
import {LoaderCircle} from "lucide-react";

interface User {
    id: string;
    name: string;
}

interface Props {
    users: User[];
}

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Sites', href: '/sites' },
    { title: 'Yeni Ekle', href: '/sites/create' },
];

export default function StationsCreate({ users }: Props) {
    const { data, setData, post, processing, errors } = useForm({
        id: '',
        name: '',
        location: '',
        manager_id: '',
        address: '',
        status: 1,
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        post(route('sites.store'));
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Yeni Site Ekle"/>

            <div className="flex h-full flex-1 flex-col gap-4 p-4">
                <h1 className="text-2xl font-semibold">Yeni Site Ekle</h1>
                <form onSubmit={handleSubmit} className="space-y-4 max-w-2xl">
                    <div className="grid gap-6">
                        <div className="grid gap-2">
                            <Label htmlFor="name">Name</Label>
                            <Input
                                id="name"
                                type="text"
                                required
                                autoFocus
                                tabIndex={1}
                                autoComplete="name"
                                name="name"
                                placeholder="İsim"
                                value={data.name}
                                onChange={(e) => setData('name', e.target.value)}
                            />
                            <InputError
                                message={errors.name}
                                className="mt-2"
                            />
                        </div>

                        <div className="grid gap-2">
                            <Label htmlFor="location">Lokasyon</Label>
                            <Input
                                id="location"
                                type="text"
                                required
                                autoFocus
                                tabIndex={2}
                                autoComplete="location"
                                name="location"
                                placeholder="Lokasyon"
                                value={data.location}
                                onChange={(e) => setData('location', e.target.value)}
                            />
                            <InputError
                                message={errors.location}
                                className="mt-2"
                            />
                        </div>

                        <div className="grid gap-2">
                            <Label htmlFor="site">Yönetici</Label>
                            <select
                                id="manager_id"
                                name="manager_id"
                                required
                                tabIndex={3}
                                className="border border-gray-800 text-gray-400 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                value={data.manager_id}
                                onChange={(e) => setData('manager_id', e.target.value)}
                            >
                                <option value="" disabled>Select Yönetici</option>
                                {users.map((user) => (
                                    <option key={user.id} value={user.id}>{user.id}</option>
                            ))}
                            </select>
                            <InputError
                                message={errors.manager_id}
                                className="mt-2"
                            />
                        </div>

                        <div className="grid gap-2">
                            <Label htmlFor="address">Adress</Label>
                            <Textarea
                                id="address"
                                required
                                autoFocus
                                tabIndex={5}
                                autoComplete="address"
                                name="address"
                                placeholder="Address"
                                value={data.address}
                                onChange={(e) => setData('address', e.target.value)}
                            />
                            <InputError
                                message={errors.address}
                                className="mt-2"
                            />
                        </div>

                        <div className="grid gap-2">
                            <Label htmlFor="role">Durum</Label>
                            <select
                                id="status"
                                name="status"
                                required
                                tabIndex={6}
                                className="border border-gray-800 text-gray-400 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                value={data.status}
                                onChange={(e) => setData('status', Number(e.target.value))}
                            >
                                <option value="" disabled>Select role</option>
                                <option value="0">Pasif</option>
                                <option value="1">Aktif</option>
                            </select>
                            <InputError message={errors.status} className="mt-2"/>
                        </div>
                    </div>
                    <Button
                        type="submit"
                        className="mt-2 w-full"
                        tabIndex={7}
                        data-test="register-station-button"
                    >
                        {processing && (
                            <LoaderCircle className="h-4 w-4 animate-spin" />
                        )}
                        Kaydet
                    </Button>
                </form>
            </div>
        </AppLayout>
    );

}
