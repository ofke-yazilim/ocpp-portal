import AppLayout from '@/layouts/app-layout';
import { Head, Link, useForm } from '@inertiajs/react';
import { type BreadcrumbItem } from '@/types';
import { Button } from '@/components/ui/button';
import { Trash2, Pencil } from 'lucide-react';

interface Log {
    id:string;
    ocpp_messages: string;
    station_id: number;
}

interface Props {
    logs: Log[];
}

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Loglar', href: '/logs' },
];

export default function StationsIndex({ logs }: Props) {
    const { delete: destroy } = useForm();

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Sites" />
            <div className="flex h-full flex-1 flex-col gap-4 p-4">
                <div className="overflow-x-auto rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <table className="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
                        <thead className="bg-neutral-50 dark:bg-neutral-900">
                        <tr>
                            <th className="px-4 py-3 text-left text-sm font-medium">İstasyon</th>
                            <th className="px-4 py-3 text-left text-sm font-medium">Message</th>
                        </tr>
                        </thead>
                        <tbody className="divide-y divide-neutral-100 dark:divide-neutral-800">
                        {logs.map((log) => (
                            <tr key={log.id}>
                                <td className="px-4 py-2 text-sm">{log.station_id}</td>
                                <td className="px-4 py-2 text-sm">{log.ocpp_messages}</td>
                            </tr>
                        ))}
                        </tbody>
                    </table>
                </div>
            </div>
        </AppLayout>
    );
}
