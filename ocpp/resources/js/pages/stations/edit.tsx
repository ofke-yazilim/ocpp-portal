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
    station: Station;
}

interface Station {
    id: number;
    name: string;
    location: string;
    site_id: string;
    firmware_version: string;
    address: string;
    station_alias: string;
    status: number;
    last_seen: string;
    approval_status: string;
}

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Stations', href: '/stations' },
    { title: 'Düzenle', href: '' },
];

export default function StationsEdit({ sites,station }: Props) {
    const { data, setData, put, processing, errors } = useForm({
        id: station.id,
        name: station.name,
        location: station.location,
        site_id: station.site_id,
        firmware_version: station.firmware_version,
        address: station.address,
        status: station.status,
        last_seen: station.last_seen,
        approval_status: station.approval_status,
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        put(route('stations.update', station.id));
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Yeni İstasyon Ekle"/>

            <div className="flex h-full flex-1 flex-col gap-4 p-4">
                <h1 className="text-2xl font-semibold">{station.name}</h1>

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
                        <Label htmlFor="site_id">Site</Label>
                        <select
                            id="site_id"
                            name="site_id"
                            required
                            tabIndex={3}
                            className="border text-gray-400 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
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

                    {/*<div className="grid gap-2">*/}
                    {/*    <Label htmlFor="firmware_version">Firmware Versiyonu</Label>*/}
                    {/*    <Input*/}
                    {/*        id="firmware_version"*/}
                    {/*        type="text"*/}
                    {/*        required*/}
                    {/*        autoFocus*/}
                    {/*        tabIndex={4}*/}
                    {/*        autoComplete="firmware_version"*/}
                    {/*        name="firmware_version"*/}
                    {/*        placeholder="Firmware Version"*/}
                    {/*        value={data.firmware_version}*/}
                    {/*        onChange={(e) => setData('firmware_version', e.target.value)}*/}
                    {/*    />*/}
                    {/*    <InputError*/}
                    {/*        message={errors.firmware_version}*/}
                    {/*        className="mt-2"*/}
                    {/*    />*/}
                    {/*</div>*/}

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
                        <Label htmlFor="role">Approval Status</Label>
                        <select
                            id="approval_status"
                            name="approval_status"
                            required
                            tabIndex={6}
                            className="border text-gray-400 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                            value={data.approval_status}
                            onChange={(e) => setData('status', Number(e.target.value))}
                        >
                            <option value="pending">Pending</option>
                            <option value="active">Aktif</option>
                            <option value="rejected">Rejected</option>
                        </select>
                        <InputError message={errors.approval_status} className="mt-2"/>
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
                        Güncelle
                    </Button>
                </form>
            </div>
        </AppLayout>
    );

}
