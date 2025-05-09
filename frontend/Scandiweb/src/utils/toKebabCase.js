export function toKebabCase(str, toUpper = false) {
  const kebab = str.trim().replace(/\s+/g, "-");
  return toUpper ? kebab.toUpperCase() : kebab.toLowerCase();
}
