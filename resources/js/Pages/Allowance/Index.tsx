import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import { PageProps } from '@/types';

export default function Index({ auth, status }: PageProps<{status?: string}>) {
    return (
        <AuthenticatedLayout
            user={ auth.user }
            header={<h2 className = "font-semibold text-xl text-gray-800 leading-tight">お小遣い</h2>}
        >
            <Head title="Allowance" />
            <h1 className = "font-semibold text-xl text-gray-800 leading-tight">お小遣い一覧だよ</h1>
        </AuthenticatedLayout>
    );
}
