import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import DeleteAllowanceForm from "@/Pages/Allowance/Partials/DeleteAllowanceForm";
import { Head, Link } from "@inertiajs/react";
import { PageProps } from "@/types";

interface Allowance {
    id: number;
    allowance: string;
    user_id: number;
}

interface Expense {
    allowance_id: number;
    expense: string;
    memo: string;
    type: string;
}

const getExpenseType = (type: string): string => {
    switch (type) {
        case "1":
            return "雑費";
        case "2":
            return "食費";
        case "3":
            return "消耗品";
        case "4":
            return "交際費";
        default:
            return "未分類";
    }
};

export default function Index({
    auth,
    allowance,
    expenses,
}: PageProps<{ allowance?: Allowance; expenses?: Expense[] }>) {
    const commonClasses =
        "rounded flex-auto w-64 text-white m-1 p-1 text-center";

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                    お小遣い
                </h2>
            }
        >
            <Head title="Allowance" />
            <div className="bg-white shadow-sm sm:rounded-lg mb-10">
                <Link href={route("allowance.edit", allowance?.user_id)}>
                    <button className="bg-gray-700 w-full text-white text-4xl px-4 py-2">
                        {allowance?.allowance ? allowance?.allowance : 0}円
                    </button>
                </Link>
                <div className="flex">
                    <label className={`${commonClasses} bg-green-400`}>
                        <Link href={route("allowance.create")}>
                            <button>お小遣い記録</button>
                        </Link>
                    </label>
                    <label className={`${commonClasses} bg-blue-400`}>
                        <a href={route("expense.create", allowance?.id)}>
                            <button>支出の記録</button>
                        </a>
                    </label>
                </div>
            </div>
            <div className="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <DeleteAllowanceForm className="max-w-xl" />
            </div>
            {expenses?.map((expense, index) => (
                <div key={index} className="bg-white shadow-sm sm:rounded-lg">
                    <div className="p-6 border-b border-gray-200 flex items-center justify-between">
                        <div className="flex flex-col">
                            <span className="text-2xl text-gray-800">
                                {expense.expense}
                            </span>
                        </div>
                        <div>
                            <p className="text-xl">{expense.memo}</p>
                            <p className="text-xl">
                                {getExpenseType(expense.type)}
                            </p>
                        </div>
                    </div>
                </div>
            ))}
        </AuthenticatedLayout>
    );
}
