import AppLayout from '@/layouts/app-layout';
import { Head, useForm } from '@inertiajs/react';
import { type BreadcrumbItem } from '@/types';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Textarea } from '@/components/ui/textarea';
import {Label} from "@/components/ui/label";
import InputError from "@/components/input-error";
import {LoaderCircle} from "lucide-react";

interface Site {
    id: string;
    name: string;
}

interface Props {
    sites: Site[];
}

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Stations', href: '/stations' },
    { title: 'Yeni Ekle', href: '/stations/create' },
];

export default function StationsCreate({ sites }: Props) {
    const { data, setData, post, processing, errors } = useForm({
        id: '',
        name: '',
        location: '',
        site_id: '',
        firmware_version: '',
        address: '',
        status: 1,
        last_seen: '',
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        post(route('stations.store'));
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Yeni İstasyon Ekle"/>

            <div className="flex h-full flex-1 flex-col gap-4 p-4">
                <h1 className="text-2xl font-semibold">Yeni İstasyon Ekle</h1>

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
                        <Label htmlFor="site">Site</Label>
                        <select
                            id="site_id"
                            name="site_id"
                            required
                            tabIndex={3}
                            className="border border-gray-800 text-gray-400 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                            value={data.site_id}
                            onChange={(e) => setData('site_id', e.target.value)}
                        >
                            <option value="" disabled>Select Site</option>
                            {sites.map((_site) => (
                                <option key={_site.id} value={_site.id}>{_site.name}</option>
                            ))}
                        </select>
                        <InputError
                            message={errors.site}
                            className="mt-2"
                        />
                    </div>

                    <div className="grid gap-2">
                        <Label htmlFor="firmware_version">Firmware Versiyonu</Label>
                        <Input
                            id="firmware_version"
                            type="text"
                            required
                            autoFocus
                            tabIndex={4}
                            autoComplete="firmware_version"
                            name="firmware_version"
                            placeholder="Firmware Version"
                            value={data.firmware_version}
                            onChange={(e) => setData('firmware_version', e.target.value)}
                        />
                        <InputError
                            message={errors.firmware_version}
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
