import RegisteredUserController from '@/actions/App/Http/Controllers/Auth/RegisteredUserController';
import { login } from '@/routes';
import { Form, Head } from '@inertiajs/react';
import { LoaderCircle } from 'lucide-react';

import InputError from '@/components/input-error';
import TextLink from '@/components/text-link';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthLayout from '@/layouts/auth-layout';
import AppLayout from '@/layouts/app-layout';
import type {BreadcrumbItem} from "@/types";

interface Site {
    id: string;
    name: string;
}

interface Props {
    sites: Site[];
}

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Users', href: '/users' },
    { title: 'Create', href: '#' },
];

export default function Register({ sites }: Props) {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Register" />
            <div className="max-w-sm flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                <Form
                    {...RegisteredUserController.store.form()}
                    resetOnSuccess={['password', 'password_confirmation']}
                    disableWhileProcessing
                    className="flex flex-col gap-6"
                >
                    {({ processing, errors }) => (
                        <>
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
                                        placeholder="Name"
                                    />
                                    <InputError
                                        message={errors.name}
                                        className="mt-2"
                                    />
                                </div>

                                <div className="grid gap-2">
                                    <Label htmlFor="surname">Surname</Label>
                                    <Input
                                        id="surname"
                                        type="text"
                                        required
                                        autoFocus
                                        tabIndex={2}
                                        autoComplete="surname"
                                        name="surname"
                                        placeholder="Surname"
                                    />
                                    <InputError
                                        message={errors.surname}
                                        className="mt-2"
                                    />
                                </div>

                                <div className="grid gap-2">
                                    <Label htmlFor="email">Email address</Label>
                                    <Input
                                        id="email"
                                        type="email"
                                        required
                                        tabIndex={3}
                                        autoComplete="email"
                                        name="email"
                                        placeholder="email@example.com"
                                    />
                                    <InputError message={errors.email} />
                                </div>

                                <div className="grid gap-2">
                                    <Label htmlFor="role">Role</Label>
                                    <select
                                        id="role"
                                        name="role"
                                        required
                                        tabIndex={4}
                                        className="border border-gray-800 text-gray-400 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                        defaultValue=""
                                    >
                                        <option value="" disabled>Select role</option>
                                        <option value="admin">Admin</option>
                                        <option value="manager">Manager</option>
                                        <option value="driver">Driver</option>
                                    </select>
                                    <InputError message={errors.role} className="mt-2" />
                                </div>

                                <div className="grid gap-2">
                                    <Label htmlFor="site">Site</Label>
                                    <select
                                        id="site"
                                        name="site"
                                        required
                                        tabIndex={5}
                                        className="border border-gray-800 text-gray-400 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                        defaultValue=""
                                    >
                                        <option value="" disabled>Select Site</option>
                                        {sites.map((site) => (
                                            <option value="{site.id}">{site.name}</option>
                                        ))}
                                    </select>
                                    <InputError
                                        message={errors.site}
                                        className="mt-2"
                                    />
                                </div>

                                <div className="grid gap-2">
                                    <Label htmlFor="apartment">Apartment</Label>
                                    <Input
                                        id="apartment"
                                        type="text"
                                        required
                                        autoFocus
                                        tabIndex={6}
                                        autoComplete="apartment"
                                        name="apartment"
                                        placeholder="apartment"
                                    />
                                    <InputError
                                        message={errors.site}
                                        className="mt-2"
                                    />
                                </div>

                                <div className="grid gap-2">
                                    <Label htmlFor="apartment">RFID</Label>
                                    <Input
                                        id="rfid"
                                        type="text"
                                        required
                                        autoFocus
                                        tabIndex={7}
                                        autoComplete="rfid"
                                        name="rfid"
                                        placeholder="rfid"
                                    />
                                    <InputError
                                        message={errors.rfid}
                                        className="mt-2"
                                    />
                                </div>

                                <div className="grid gap-2">
                                    <Label htmlFor="password">Password</Label>
                                    <Input
                                        id="password"
                                        type="password"
                                        required
                                        tabIndex={8}
                                        autoComplete="new-password"
                                        name="password"
                                        placeholder="Password"
                                    />
                                    <InputError message={errors.password} />
                                </div>

                                <div className="grid gap-2">
                                    <Label htmlFor="password_confirmation">
                                        Confirm password
                                    </Label>
                                    <Input
                                        id="password_confirmation"
                                        type="password"
                                        required
                                        tabIndex={9}
                                        autoComplete="new-password"
                                        name="password_confirmation"
                                        placeholder="Confirm password"
                                    />
                                    <InputError
                                        message={errors.password_confirmation}
                                    />
                                </div>

                                <Button
                                    type="submit"
                                    className="mt-2 w-full"
                                    tabIndex={9}
                                    data-test="register-user-button"
                                >
                                    {processing && (
                                        <LoaderCircle className="h-4 w-4 animate-spin" />
                                    )}
                                    Create account
                                </Button>
                            </div>

                            {/*<div className="text-center text-sm text-muted-foreground">*/}
                            {/*    Already have an account?{' '}*/}
                            {/*    <TextLink href={login()} tabIndex={10}>*/}
                            {/*        Log in*/}
                            {/*    </TextLink>*/}
                            {/*</div>*/}
                        </>
                    )}
                </Form>
            </div>
        </AppLayout>
    );
}
