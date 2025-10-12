import AppLayout from '@/layouts/app-layout';
import { Head, Link, useForm } from '@inertiajs/react';
import { type BreadcrumbItem } from '@/types';
import { Button } from '@/components/ui/button';
import { Trash2, Pencil } from 'lucide-react';

interface User {
    id: number;
    name: string;
    email: string;
}

interface Props {
    users: User[];
}

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Users', href: '/users' },
];

export default function UsersIndex({ users }: Props) {
    const { delete: destroy } = useForm();

    const handleDelete = (id: number) => {
        if (confirm('Bu kullanıcıyı silmek istediğinize emin misiniz?')) {
            destroy(route('users.destroy', id));
        }
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Users" />

            <div className="flex h-full flex-1 flex-col gap-4 p-4">
                <div className="flex items-center justify-between">
                    <h1 className="text-2xl font-semibold">Users</h1>
                    <Link href="/register">
                        <Button variant="default">Yeni Ekle</Button>
                    </Link>
                </div>

                <div className="overflow-x-auto rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <table className="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
                        <thead className="bg-neutral-50 dark:bg-neutral-900">
                        <tr>
                            <th className="px-4 py-3 text-left text-sm font-medium">ID</th>
                            <th className="px-4 py-3 text-left text-sm font-medium">Name</th>
                            <th className="px-4 py-3 text-left text-sm font-medium">Email</th>
                            <th className="px-4 py-3 text-right text-sm font-medium">Actions</th>
                        </tr>
                        </thead>
                        <tbody className="divide-y divide-neutral-100 dark:divide-neutral-800">
                        {users.map((user) => (
                            <tr key={user.id}>
                                <td className="px-4 py-2 text-sm">{user.id}</td>
                                <td className="px-4 py-2 text-sm">{user.name}</td>
                                <td className="px-4 py-2 text-sm">{user.email}</td>
                                <td className="px-4 py-2 text-right text-sm">
                                    <Link
                                        href={route('users.edit', user.id)}
                                        className="inline-flex items-center justify-center rounded-md p-2 hover:bg-neutral-200 dark:hover:bg-neutral-800"
                                    >
                                        <Pencil size={16} />
                                    </Link>
                                    <button
                                        onClick={() => handleDelete(user.id)}
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
