import React from "react";

const Header: React.FC = () => {
    const navItems = ["Dashboard", "Charge Points", "Sessions", "Users", "Settings"];

    return (
        <header className="flex items-center justify-between border-b border-primary/20 dark:border-primary/30 px-6 sm:px-10 py-4">
            <div className="flex items-center gap-3">
                <div className="w-8 h-8 text-primary">
                    <svg fill="none" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M4 42.4379C4 42.4379 14.0962 36.0744 24 41.1692C35.0664 46.8624 44 42.2078 44 42.2078L44 7.01134C44 7.01134 35.068 11.6577 24.0031 5.96913C14.0971 0.876274 4 7.27094 4 7.27094L4 42.4379Z"
                            fill="currentColor"
                        />
                    </svg>
                </div>
                <h2 className="text-xl font-bold text-gray-900 dark:text-white">ChargePoint Portal</h2>
            </div>

            <div className="flex items-center gap-4 sm:gap-8">
                <nav className="hidden md:flex items-center gap-6">
                    {navItems.map((item, i) => (
                        <a
                            key={i}
                            href="#"
                            className={`text-sm font-medium ${
                                i === 0
                                    ? "text-primary"
                                    : "text-gray-600 dark:text-gray-300 hover:text-primary dark:hover:text-primary"
                            }`}
                        >
                            {item}
                        </a>
                    ))}
                </nav>

                <div
                    className="bg-center bg-no-repeat bg-cover rounded-full size-10"
                    style={{
                        backgroundImage:
                            'url("https://lh3.googleusercontent.com/aida-public/AB6AXuD9pNjCU-8QRKEEbCc6GqD4DM0U-RJGYiNlGlyZXq6EGqH9ftQhluXZz2mZd7d5GICH4wh1NfxDQ4QvC9iGSsP_ib2ooCvbxG30ep_BYR_PYc-2YDjvG61OE-hkGBLuwrYanb-o5WO9YyoOmGJ8d-1zsRqhO4DV8PiwOvOFd9v5_HnNQ9Ldm1Pa6KGC63h-YVBrLSPb1msovllOTCZtd7SIQfWeAmKyund7wIqY2t1JGsT5OyVF8x1vHQLh_nEBxdxZ6xE142nPnR8")',
                    }}
                />
            </div>
        </header>
    );
};

export default Header;
