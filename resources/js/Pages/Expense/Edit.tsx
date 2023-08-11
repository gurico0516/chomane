import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import EditExpenseInformationForm from "./Partials/EditExpenseInformationForm";
import { Head } from "@inertiajs/react";
import { PageProps } from "@/types";

export default function Edit({ auth, status }: PageProps<{ status?: string }>) {
    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                    経費記録
                </h2>
            }
        >
            <Head title="Expense Edit" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <EditExpenseInformationForm
                        status={status}
                        className="max-w-xl"
                    />
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
