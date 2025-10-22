import AppLayout from '@/layouts/app-layout';
import { Head, Link, useForm } from '@inertiajs/react';
import { type BreadcrumbItem } from '@/types';
import { Button } from '@/components/ui/button';
import { Trash2, Pencil } from 'lucide-react';

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
}

interface Props {
    stations: Station[];
}

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Stations', href: '/stations' },
];

export default function StationsIndex({ stations }: Props) {
    const { delete: destroy } = useForm();

    const handleDelete = (id: number) => {
        if (confirm('Bu istasyonu silmek istediğinize emin misiniz?')) {
            destroy(route('stations.destroy', id));
        }
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Stations" />

            <div className="flex h-full flex-1 flex-col gap-4 p-4">
                <div className="flex items-center justify-between">
                    <h1 className="text-2xl font-semibold">İstasyonlar</h1>
                    <Link href="/stations/create">
                        <Button variant="default">Yeni Ekle</Button>
                    </Link>
                </div>

                <div className="overflow-x-auto rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <table className="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
                        <thead className="bg-neutral-50 dark:bg-neutral-900">
                        <tr>
                            <th className="px-4 py-3 text-left text-sm font-medium">ID</th>
                            <th className="px-4 py-3 text-left text-sm font-medium">Name</th>
                            <th className="px-4 py-3 text-left text-sm font-medium">Site ID</th>
                            <th className="px-4 py-3 text-left text-sm font-medium">Alias</th>
                            <th className="px-4 py-3 text-left text-sm font-medium">Location</th>
                            <th className="px-4 py-3 text-left text-sm font-medium">Status</th>
                            <th className="px-4 py-3 text-left text-sm font-medium">Firmware Version</th>
                            <th className="px-4 py-3 text-right text-sm font-medium">Last Seen</th>
                        </tr>
                        </thead>
                        <tbody className="divide-y divide-neutral-100 dark:divide-neutral-800">
                        {stations.map((station) => (
                            <tr key={station.id}>
                                <td className="px-4 py-2 text-sm">{station.id}</td>
                                <td className="px-4 py-2 text-sm">{station.name}</td>
                                <td className="px-4 py-2 text-sm">{station.site_id}</td>
                                <td className="px-4 py-2 text-sm">{station.station_alias}</td>
                                <td className="px-4 py-2 text-sm">{station.location}</td>
                                <td className="px-4 py-2 text-sm">{station.status}</td>
                                <td className="px-4 py-2 text-sm">{station.firmware_version}</td>
                                <td className="px-4 py-2 text-sm">{station.last_seen}</td>
                                <td className="px-4 py-2 text-right text-sm">
                                    <Link
                                        href={route('stations.edit', station.id)}
                                        className="inline-flex items-center justify-center rounded-md p-2 hover:bg-neutral-200 dark:hover:bg-neutral-800"
                                    >
                                        <Pencil size={16} />
                                    </Link>
                                    <button
                                        onClick={() => handleDelete(station.id)}
                                        className="inline-flex items-center justify-center rounded-md p-2 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/30"
                                    >
                                        <Trash2 size={16} />
                                    </button>
                                </td>
                            </tr>
                        ))}
                        </tbody>
                    </table>
                </div>
            </div>
        </AppLayout>
    );
}
