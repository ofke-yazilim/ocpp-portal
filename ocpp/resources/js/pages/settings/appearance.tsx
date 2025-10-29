import { Head } from '@inertiajs/react';

import AppearanceTabs from '@/components/appearance-tabs';
import HeadingSmall from '@/components/heading-small';
import { type BreadcrumbItem } from '@/types';

import AppLayout from '@/layouts/app-layout';
import SettingsLayout from '@/layouts/settings/layout';
import { edit as editAppearance } from '@/routes/appearance';

import { RoleProvider } from '@/context/role-context';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Appearance settings',
        href: editAppearance().url,
    },
];

interface Props {
    srole: string;
}

export default function Appearance({ srole }: Props) {
    return (
        <RoleProvider value={srole}>
            <AppLayout breadcrumbs={breadcrumbs}>
                <Head title="Appearance settings" />

                <SettingsLayout>
                    <div className="space-y-6">
                        <HeadingSmall
                            title="Appearance settings"
                            description="Update your account's appearance settings"
                        />
                        <AppearanceTabs />
                    </div>
                </SettingsLayout>
            </AppLayout>
        </RoleProvider>
    );
}
