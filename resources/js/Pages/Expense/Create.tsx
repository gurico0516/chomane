import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import CreateExpenseInformationForm from "./Partials/CreateExpenseInformationForm";
import { Head } from "@inertiajs/react";
import { PageProps } from "@/types";

export default function Create({
    auth,
    status,
}: PageProps<{ status?: string }>) {
    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                    経費記録
                </h2>
            }
        >
            <Head title="Expense Create" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <CreateExpenseInformationForm
                        status={status}
                        className="max-w-xl"
                    />
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
