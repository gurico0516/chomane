import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import DeleteAllowanceForm from "@/Pages/Allowance/Partials/DeleteAllowanceForm";
import DeleteExpenseForm from "@/Pages/Expense/Partials/DeleteExpenseForm";
import ExpenseChart from "@/Pages/Expense/Partials/ExpenseChart";
import { Head, Link } from "@inertiajs/react";
import { PageProps } from "@/types";

interface Allowance {
    id: number;
    allowance: string;
    user_id: number;
}

interface Expense {
    id?: number;
    allowance_id?: number;
    expense?: string;
    memo?: string;
    type: string;
    total: number;
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
    weeklyExpenses,
}: PageProps<{ allowance?: Allowance; expenses?: Expense[]; weeklyExpenses?: Expense[]; }>) {
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

            <div className="w-11/12 mx-auto my-10">
                <div className="bg-white shadow-lg sm:rounded-lg overflow-hidden p-2">
                    {allowance?.user_id ? (
                        <Link href={route("allowance.edit", allowance?.user_id)}>
                            <button className="bg-gray-800 hover:bg-gray-700 w-full text-white text-6xl px-4 py-2 shadow-md transition-transform transform hover:scale-105">
                                {allowance?.allowance ? Number(allowance?.allowance).toLocaleString() : '0'}円
                            </button>
                        </Link>
                    ) : (
                        <Link href={route("allowance.create")}>
                            <button className="bg-gray-800 hover:bg-gray-700 w-full text-white text-6xl px-4 py-2 shadow-md transition-transform transform hover:scale-105">
                                {allowance?.allowance ? Number(allowance?.allowance).toLocaleString() : '0'}円
                            </button>
                        </Link>
                    )}
                    <div className="flex">
                        <label className={`${commonClasses} bg-green-500 hover:bg-green-600 shadow-md transition-transform transform hover:scale-105`}>
                            <Link href={route("allowance.create")}>
                                <button className="text-2xl">お小遣い記録</button>
                            </Link>
                        </label>
                        <label className={`${commonClasses} bg-blue-500 hover:bg-blue-600 shadow-md transition-transform transform hover:scale-105`}>
                            <a href={route("expense.create", allowance?.id)}>
                                <button className="text-2xl">支出の記録</button>
                            </a>
                        </label>
                    </div>
                </div>

                <div className="flex items-center space-x-6 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <DeleteAllowanceForm className="flex-grow max-w-xl text-center" />
                    <DeleteExpenseForm className="flex-grow max-w-xl text-center" />
                </div>

                <div className="mt-8 bg-gray-800 p-4 rounded-lg">
                <h2 className="text-white mb-4">1週間の支出グラフ</h2>
                <ExpenseChart expenses={weeklyExpenses} />
                <div className="mt-4 flex flex-wrap space-y-2">
                    <div className="mt-4 flex flex-wrap">
                        <div className="flex items-center mr-4 mb-2">
                            <div style={{ backgroundColor: '#FF6384' }} className="w-4 h-4 mr-2"></div>
                            <span className="text-white">雑費</span>
                        </div>
                        <div className="flex items-center mr-4 mb-2">
                            <div style={{ backgroundColor: '#36A2EB' }} className="w-4 h-4 mr-2"></div>
                            <span className="text-white">食費</span>
                        </div>
                        <div className="flex items-center mr-4 mb-2">
                            <div style={{ backgroundColor: '#FFCE56' }} className="w-4 h-4 mr-2"></div>
                            <span className="text-white">消耗品費</span>
                        </div>
                        <div className="flex items-center mr-4 mb-2">
                            <div style={{ backgroundColor: '#4BC0C0' }} className="w-4 h-4 mr-2"></div>
                            <span className="text-white">交通費</span>
                        </div>
                        <div className="flex items-center mr-4 mb-2">
                            <div style={{ backgroundColor: '#f1f1f1' }} className="w-4 h-4 mr-2"></div>
                            <span className="text-white">未登録</span>
                        </div>
                    </div>
                </div>

                {expenses?.map((expense, index) => (
                <div key={index} className="mt-4 bg-white shadow-sm sm:rounded-lg transition-transform transform hover:scale-105">
                    <Link href={route("expense.edit", expense?.id)}>
                        <a className="block p-6 border-b border-gray-200 flex items-center justify-between cursor-pointer">
                            <div className="flex flex-col">
                                <span className="text-2xl text-gray-800 mb-2">
                                    {expense.expense}
                                </span>
                                <p className="text-gray-600">{expense.memo}</p>
                            </div>
                            <div className="flex flex-col items-end">
                                <p className="text-xl text-gray-700 mb-2">
                                    {getExpenseType(expense.type)}
                                </p>
                                {/* 他の項目が必要な場合はこちらに追加 */}
                            </div>
                        </a>
                    </Link>
                </div>
            ))}
            </div>

            </div>
        </AuthenticatedLayout>
    );
}
