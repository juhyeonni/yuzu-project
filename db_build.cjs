// BASIC DEPENDENCIES
const fs = require("fs");
const { spawnSync } = require("child_process");

// GLOBAL REQUIRED
// ---
var args = process.argv.slice(2);
var util = {
    checkDockerInstalled: function () {
        const result = spawnSync("docker", ["--version"], { stdio: "pipe" });
        return result.status === 0;
    },
    parseEnv: function (filePath) {
        try {
            const envFileContent = fs.readFileSync(filePath, "utf8");
            const envLines = envFileContent.trim().split("\n");
            const envVariables = {};
            for (const line of envLines) {
                if (!line.startsWith("#")) {
                    const [key, value] = line.split("=");
                    envVariables[key] = value;
                }
            }
            return envVariables;
        } catch (err) {
            return null;
        }
    },
};
var options = [
    {
        name: "--name",
        description: "Name of the Docker container",
        defaultValue: "test-db-container",
    },
    {
        name: "--port",
        description: "Port to expose the database on",
        defaultValue: "3306",
    },
    {
        name: "--image",
        description: "Docker image(MySQL) to use",
        defaultValue: "mariadb:10.11.4-jammy",
    },
];
// ---

/**
 * @typedef {Object} UsageOption
 * @property {string} name
 * @property {string} description
 * @property {string} defaultValue
 */
/**
 * @param {UsageOption[]} options
 */
function printUsage(options) {
    console.log("Usage: node db_build.cjs <.env> [...options]");
    console.log("[options]: ");
    for (const option of options) {
        console.log(`\t${option.name}\t${option.description}`);
    }
}
/**
 * @typedef {Object} Vars
 * @property {string} name
 * @property {string} port
 * @property {string} image
 * @property {string} password
 * @property {string} database
 */
/**
 * @param {Vars} vars
 */
function printVars(vars) {
    console.log("---- DB INFORMATION ----", "\x1b[37m", "\x1b[2m");
    for (const key in vars) {
        if (key === "password") continue;
        console.log(` ${key}: ${vars[key]}`);
    }
    console.log("\x1b[0m------------------------");
}

/**
 * @returns {void}
 * @description
 * 1. exit if Docker is not installed
 * 2. exit if .env file is not provided
 *
 * GLOBAL REQUIRED
 * - require `args` variable
 * - require `util` variable
 */
function init() {
    // 0. Check if help is requested
    if (
        args.includes("--help") ||
        args.includes("-h") ||
        args.includes("--usage")
    ) {
        printUsage(options);
        process.exit(0);
    }

    // 1. Check if Docker is installed
    if (!util.checkDockerInstalled()) {
        console.log(
            "Docker is not installed. Please install Docker and try again."
        );
        process.exit(1);
    }

    // 2. Check if .env file is provided
    if (!process.argv[2]) {
        console.log("Please provide path to .env file as argument.");
        process.exit(1);
    }
}

/**
 * @returns {void}
 * @description
 * 1. Read .env file
 * 2. Start Docker container
 *
 * GLOBAL REQUIRED
 * - require `args` variable
 * - require `util` variable
 */
function run() {
    init();

    // Read .env file
    const envVars = util.parseEnv(process.argv[2]);
    const vars = {
        ...options.reduce((acc, option) => {
            const arg = args.find((arg) => arg.startsWith(option.name + "="));
            acc[option.name.replace("--", "")] = arg
                ? arg.split("=")[1]
                : option.defaultValue;
            return acc;
        }, {}),
        password: envVars.DB_PASSWORD,
        database: envVars.DB_DATABASE,
        username: envVars.DB_USERNAME,
    };

    const dockerArgs = [
        "run",
        "-d",
        "--name",
        `${vars.name}`,
        "-p",
        `${vars.port}:3306`,
        "-e",
        `MYSQL_ROOT_PASSWORD=${vars.password}`,
        "-e",
        `MYSQL_DATABASE=${vars.database}`,
        "-e",
        `MYSQL_USER=${vars.username}`,
        "-e",
        `MYSQL_PASSWORD=${vars.password}`,
        `${vars.image}`,
        "--bind-address=0.0.0.0",
    ];

    // Start Docker container
    console.log("\x1b[34mStarting Docker container...", "\x1b[0m");
    printVars(vars);
    const dockerProcess = spawnSync("docker", dockerArgs, { stdio: "inherit" });
    if (dockerProcess.status === 125) {
        console.error("\n\x1b[41mFailed to start Docker container.");
        process.exit(1);
    }
}

run();

// generated by gpt-3.5-turbo-0613
// prompted by github.com/d556f8
