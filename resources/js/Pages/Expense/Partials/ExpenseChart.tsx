import React from 'react';
import { Pie } from 'react-chartjs-2';
import { Chart, DoughnutController, ArcElement, CategoryScale, LinearScale } from 'chart.js';

Chart.register(DoughnutController, ArcElement, CategoryScale, LinearScale);

interface ExpenseProps {
    expenses?: { type: string; total: number; }[];
}

const ExpenseChart: React.FC<ExpenseProps> = ({ expenses }) => {
    const isEmpty = !expenses || expenses.length === 0;
    
    const data = {
        labels: isEmpty ? ['No Data'] : expenses.map(item => {
            switch(item.type) {
                case '1': return '雑費';
                case '2': return '食費';
                case '3': return '消耗品費';
                case '4': return '交通費';
                default: return 'その他';
            }
        }),
        datasets: [{
            data: isEmpty ? [1] : expenses.map(item => item.total),
            backgroundColor: isEmpty ? ['#f1f1f1'] : ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0'],
        }],
    };

    const options = {
        plugins: {
            tooltip: {
                callbacks: {
                    label: function (context: any) {
                        const label = context.label || '';
                        const value = context.parsed;
                        return `${label}: ${value}`;
                    }
                }
            },
        },
        responsive: true,
        maintainAspectRatio: false
    };

    return (
        <div className="w-64 h-64 mx-auto flex items-center justify-center">
            <Pie data={data} options={options} />
        </div>
    );
};

export default ExpenseChart;
