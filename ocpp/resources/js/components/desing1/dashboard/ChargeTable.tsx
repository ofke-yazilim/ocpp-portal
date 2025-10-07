import React from "react";

interface ChargeRow {
    id: string;
    status: string;
    location: string;
    lastSession: string;
    color: string;
}

const ChargeTable: React.FC = () => {
    const rows: ChargeRow[] = [
        { id: "CP001", status: "Online", location: "Parking Lot A", lastSession: "1 hour ago", color: "green" },
        { id: "CP002", status: "Offline", location: "Parking Lot B", lastSession: "2 days ago", color: "red" },
        { id: "CP003", status: "Online", location: "Parking Lot A", lastSession: "30 minutes ago", color: "green" },
        { id: "CP004", status: "Charging", location: "Parking Lot C", lastSession: "2 hours ago", color: "blue" },
        { id: "CP005", status: "Offline", location: "Parking Lot B", lastSession: "1 day ago", color: "red" },
    ];

    return (
        <div className="overflow-hidden rounded-lg border border-primary/20 dark:border-primary/30 bg-white dark:bg-primary/10 shadow-sm">
            <table className="w-full text-left">
                <thead className="bg-primary/5 dark:bg-primary/20">
                <tr>
                    <th className="p-4 text-sm font-semibold text-gray-700 dark:text-gray-200">Charge Point ID</th>
                    <th className="p-4 text-sm font-semibold text-gray-700 dark:text-gray-200">Status</th>
                    <th className="p-4 text-sm font-semibold text-gray-700 dark:text-gray-200 hidden md:table-cell">Location</th>
                    <th className="p-4 text-sm font-semibold text-gray-700 dark:text-gray-200 hidden lg:table-cell">Last Session</th>
                </tr>
                </thead>
                <tbody className="divide-y divide-primary/10 dark:divide-primary/20">
                {rows.map((row) => (
                    <tr key={row.id}>
                        <td className="p-4 text-sm font-medium text-gray-900 dark:text-white">{row.id}</td>
                        <td className="p-4 text-sm">
                <span
                    className={`inline-flex items-center gap-2 rounded-full bg-${row.color}-100 dark:bg-${row.color}-900/50 px-3 py-1 text-xs font-semibold text-${row.color}-800 dark:text-${row.color}-300`}
                >
                  <span className={`h-2 w-2 rounded-full bg-${row.color}-500`} />
                    {row.status}
                </span>
                        </td>
                        <td className="p-4 text-sm text-gray-600 dark:text-gray-400 hidden md:table-cell">{row.location}</td>
                        <td className="p-4 text-sm text-gray-600 dark:text-gray-400 hidden lg:table-cell">{row.lastSession}</td>
                    </tr>
                ))}
                </tbody>
            </table>
        </div>
    );
};

export default ChargeTable;
