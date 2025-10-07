import React from "react";
import Header from "./Header";
import StatsCard from "./StatsCard";
import ChargeTable from "./ChargeTable";

const Dashboard: React.FC = () => {
    const cards = [
        { icon: "power", label: "Charge Points Online", value: "15 / 20" },
        { icon: "electric_bolt", label: "Total Energy Consumed", value: "2345 kWh" },
        { icon: "ev_station", label: "Active Sessions", value: "3" },
        { icon: "history", label: "Recent Activity", value: "Last session: 2h ago" },
    ];

    return (
        <div className="bg-background-light dark:bg-background-dark font-display text-gray-800 dark:text-gray-200 min-h-screen flex flex-col">
            <Header />
            <main className="flex-1 px-4 sm:px-6 lg:px-10 py-8">
                <div className="max-w-7xl mx-auto">
                    <div className="flex flex-col sm:flex-row justify-between items-start gap-4 mb-8">
                        <h1 className="text-3xl font-bold tracking-tight text-gray-900 dark:text-white">
                            Dashboard
                        </h1>
                    </div>

                    <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        {cards.map((card, i) => (
                            <StatsCard key={i} {...card} />
                        ))}
                    </div>

                    <h2 className="text-2xl font-bold tracking-tight text-gray-900 dark:text-white mt-12 mb-6">
                        Charge Point Status
                    </h2>

                    <ChargeTable />
                </div>
            </main>
        </div>
    );
};

export default Dashboard;
