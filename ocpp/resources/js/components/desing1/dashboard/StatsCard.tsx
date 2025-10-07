import React from "react";

interface StatsCardProps {
    icon: string;
    label: string;
    value: string;
}

const StatsCard: React.FC<StatsCardProps> = ({ icon, label, value }) => {
    return (
        <div className="flex flex-col gap-2 rounded-lg p-6 bg-white dark:bg-primary/10 border border-primary/20 dark:border-primary/30 shadow-sm">
            <div className="flex items-center gap-4">
        <span className="material-symbols-outlined text-primary text-3xl">
          {icon}
        </span>
                <p className="text-base font-medium text-gray-600 dark:text-gray-300">
                    {label}
                </p>
            </div>
            <p className="text-4xl font-bold text-gray-900 dark:text-white">{value}</p>
        </div>
    );
};

export default StatsCard;
