import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import EditAllownceInformationForm from './Partials/EditAllownceInformationForm';
import { Head } from '@inertiajs/react';
import { PageProps } from '@/types';

export default function Edit({ auth, status }: PageProps<{status?: string}>) {
    return (
        <AuthenticatedLayout
            user={ auth.user }
            header={<h2 className = "font-semibold text-xl text-gray-800 leading-tight">お小遣い記録</h2>}
        >
            <Head title="Allowance Edit" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <EditAllownceInformationForm
                        status={status}
                        className="max-w-xl"
                    />
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
